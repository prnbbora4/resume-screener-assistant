<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeAnalysisRequest;
use App\Jobs\AnalyzeResumeJob;
use App\Models\ResumeAnalysis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ResumeAnalysisController extends Controller
{
    public function create(): View
    {
        return view('analyses.create');
    }

    public function store(StoreResumeAnalysisRequest $request): RedirectResponse
    {
        if (blank(config('services.openai.key'))) {
            return back()
                ->withInput($request->safe()->only(['candidate_name']))
                ->withErrors([
                    'analysis' => 'AI analysis is not configured yet. Please contact the application administrator.',
                ]);
        }

        $validated = $request->validated();
        $trackingId = (string) Str::uuid();

        Cache::put('resume-analysis:'.$trackingId, [
            'status' => 'queued',
            'message' => 'Your analysis is queued and will begin shortly.',
        ], now()->addDay());

        AnalyzeResumeJob::dispatch(
            $trackingId,
            $validated['candidate_name'],
            $validated['job_description'],
            $validated['resume'],
        );

        return redirect()->route('analyses.processing', ['trackingId' => $trackingId]);
    }

    public function processing(string $trackingId): View
    {
        abort_unless(Str::isUuid($trackingId), 404);

        $state = Cache::get('resume-analysis:'.$trackingId);
        abort_unless($state !== null, 404);

        if (($state['status'] ?? null) === 'completed') {
            return redirect()->route('analyses.show', ['analysis' => $state['analysis_id']]);
        }

        return view('analyses.processing', compact('trackingId', 'state'));
    }

    public function status(string $trackingId): JsonResponse
    {
        abort_unless(Str::isUuid($trackingId), 404);

        $state = Cache::get('resume-analysis:'.$trackingId);
        abort_unless($state !== null, 404);

        return response()
            ->json($state)
            ->header('Cache-Control', 'no-store, private');
    }

    public function show(ResumeAnalysis $analysis): View
    {
        return view('analyses.show', compact('analysis'));
    }
}
