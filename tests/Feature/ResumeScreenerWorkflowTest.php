<?php

use App\Jobs\AnalyzeResumeJob;
use App\Models\ResumeAnalysis;
use App\Services\OpenAiResumeAnalysisService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

function validAnalysisInput(array $overrides = []): array
{
    return array_merge([
        'candidate_name' => 'Jordan Rivera',
        'job_description' => str_repeat('Role description with relevant experience and skills. ', 2),
        'resume' => str_repeat('Candidate experience includes relevant projects and skills. ', 2),
    ], $overrides);
}

function validAiReport(): array
{
    return [
        'match_score' => 82,
        'matching_skills' => ['PHP', 'Laravel', 'SQL', 'Testing', 'Communication'],
        'skill_gaps' => ['Cloud deployment', 'System design', 'Leadership'],
        'interview_questions' => ['Question one?', 'Question two?', 'Question three?'],
    ];
}

test('public dashboard and analysis form render', function () {
    $this->get(route('dashboard'))->assertOk()
        ->assertSee('Welcome to Resume Screener Assistant');

    $this->get(route('analyses.create'))->assertOk()
        ->assertSee('New Resume Analysis');
});

test('analysis submission validates input and does not retain source text in session', function () {
    config(['services.openai.key' => 'test-key']);
    Queue::fake();

    $response = $this->from(route('analyses.create'))->post(route('analyses.store'), [
        'candidate_name' => 'Jordan Rivera',
        'job_description' => 'too short job details',
        'resume' => 'too short resume',
    ]);

    $response->assertRedirect(route('analyses.create'))
        ->assertSessionHasErrors(['job_description', 'resume'])
        ->assertSessionHasInput('candidate_name', 'Jordan Rivera')
        ->assertSessionMissing('job_description')
        ->assertSessionMissing('resume');

    Queue::assertNothingPushed();
    expect(ResumeAnalysis::query()->count())->toBe(0);
});

test('analysis submission fails clearly when OpenAI is not configured', function () {
    config(['services.openai.key' => null]);
    Queue::fake();

    $this->from(route('analyses.create'))
        ->post(route('analyses.store'), validAnalysisInput())
        ->assertRedirect(route('analyses.create'))
        ->assertSessionHasErrors('analysis');

    Queue::assertNothingPushed();
    expect(ResumeAnalysis::query()->count())->toBe(0);
});

test('valid analysis is queued with temporary status and no report row yet', function () {
    config(['services.openai.key' => 'test-key']);
    Queue::fake();

    $response = $this->post(route('analyses.store'), validAnalysisInput());
    $trackingId = (string) Str::of($response->headers->get('Location'))->afterLast('/');

    $response->assertRedirect(route('analyses.processing', ['trackingId' => $trackingId]));
    Queue::assertPushed(AnalyzeResumeJob::class);
    expect(ResumeAnalysis::query()->count())->toBe(0)
        ->and(Cache::get('resume-analysis:'.$trackingId)['status'])->toBe('queued');
});

test('queued source documents are encrypted and never appear as plain text in the queue table', function () {
    config(['queue.default' => 'database']);
    $jobDescription = 'SENSITIVE JOB DESCRIPTION '.Str::random(24);
    $resume = 'SENSITIVE CANDIDATE RESUME '.Str::random(24);

    Queue::connection('database')->push(
        new AnalyzeResumeJob((string) Str::uuid(), 'Jordan Rivera', $jobDescription, $resume),
    );

    $payload = DB::table('jobs')->value('payload');

    expect($payload)->toBeString()
        ->and($payload)->not->toContain($jobDescription)
        ->and($payload)->not->toContain($resume);
});

test('analysis job validates provider result and saves only the report', function () {
    config([
        'services.openai.key' => 'test-key',
        'services.openai.model' => 'test-model',
        'services.openai.base_url' => 'https://api.openai.com/v1',
    ]);
    Http::fake([
        'api.openai.com/v1/chat/completions' => Http::response([
            'choices' => [
                ['message' => ['content' => json_encode(validAiReport(), JSON_THROW_ON_ERROR)]],
            ],
        ]),
    ]);

    $trackingId = (string) Str::uuid();
    Cache::put('resume-analysis:'.$trackingId, ['status' => 'queued'], now()->addDay());

    (new AnalyzeResumeJob(
        $trackingId,
        'Jordan Rivera',
        validAnalysisInput()['job_description'],
        validAnalysisInput()['resume'],
    ))->handle(app(OpenAiResumeAnalysisService::class));

    $analysis = ResumeAnalysis::query()->sole();

    expect($analysis->candidate_name)->toBe('Jordan Rivera')
        ->and($analysis->match_score)->toBe(82)
        ->and($analysis->matching_skills)->toHaveCount(5)
        ->and($analysis->skill_gaps)->toHaveCount(3)
        ->and($analysis->interview_questions)->toHaveCount(3)
        ->and(Cache::get('resume-analysis:'.$trackingId)['status'])->toBe('completed')
        ->and(Cache::get('resume-analysis:'.$trackingId)['analysis_id'])->toBe($analysis->id);

    Http::assertSent(fn ($request) => $request->hasHeader('Authorization', 'Bearer test-key')
        && $request['model'] === 'test-model');
});

test('malformed provider reports are rejected and not persisted', function () {
    config(['services.openai.key' => 'test-key']);
    Http::fake([
        'api.openai.com/v1/chat/completions' => Http::response([
            'choices' => [
                ['message' => ['content' => '{"match_score":101,"matching_skills":[],"skill_gaps":[],"interview_questions":[]}']],
            ],
        ]),
    ]);

    expect(fn () => app(OpenAiResumeAnalysisService::class)->analyze('job description', 'resume'))
        ->toThrow(RuntimeException::class, 'unexpected format');

    expect(ResumeAnalysis::query()->count())->toBe(0);
});

test('history filters search and constrain score while pagination keeps query parameters', function () {
    ResumeAnalysis::create([
        'candidate_name' => 'Jordan Rivera',
        ...validAiReport(),
    ]);
    ResumeAnalysis::create([
        'candidate_name' => 'Casey Morgan',
        ...array_merge(validAiReport(), ['match_score' => 42]),
    ]);

    $this->get(route('analyses.history', [
        'search' => 'Jordan',
        'min_score' => 80,
        'max_score' => 90,
    ]))
        ->assertOk()
        ->assertSee('Jordan Rivera')
        ->assertDontSee('Casey Morgan')
        ->assertSee('name="search"', false);
});

test('analysis report route renders a completed report', function () {
    $analysis = ResumeAnalysis::create([
        'candidate_name' => 'Jordan Rivera',
        ...validAiReport(),
    ]);

    $this->get(route('analyses.show', ['analysis' => $analysis->id]))
        ->assertOk()
        ->assertSee('Candidate Analysis Report')
        ->assertSee('Jordan Rivera')
        ->assertSee('>82<', false);
});

test('history filter request rejects minimum score greater than maximum score', function () {
    $this->get(route('analyses.history', [
        'min_score' => 90,
        'max_score' => 50,
    ]))
        ->assertRedirect()
        ->assertSessionHasErrors('min_score');
});
