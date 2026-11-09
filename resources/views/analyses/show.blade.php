@php
    $candidateName = is_string($analysis->candidate_name ?? null) && trim($analysis->candidate_name) !== ''
        ? $analysis->candidate_name
        : 'Candidate';
    $rawScore = $analysis->match_score ?? null;
    $score = is_numeric($rawScore) ? max(0, min(100, (int) $rawScore)) : null;
    $matchingSkills = is_array($analysis->matching_skills ?? null)
        ? array_slice($analysis->matching_skills, 0, 5)
        : [];
    $skillGaps = is_array($analysis->skill_gaps ?? null)
        ? array_slice($analysis->skill_gaps, 0, 3)
        : [];
    $interviewQuestions = is_array($analysis->interview_questions ?? null)
        ? array_slice($analysis->interview_questions, 0, 3)
        : [];
    $createdAt = $analysis->created_at ?? null;

    [$scoreLabel, $scoreTone, $scoreDescription] = match (true) {
        $score === null => ['Score unavailable', 'gray', 'This report does not contain a valid match score.'],
        $score >= 80 => ['Strong Match', 'green', 'The candidate aligns strongly with the role requirements.'],
        $score >= 50 => ['Moderate Match', 'amber', 'The candidate shows a partial match to the role requirements.'],
        default => ['Low Match', 'red', 'The candidate has limited alignment with the role requirements.'],
    };

    $scoreToneClasses = match ($scoreTone) {
        'green' => [
            'card' => 'border-emerald-200 bg-emerald-50/60',
            'icon' => 'bg-emerald-100 text-emerald-700',
            'badge' => 'bg-emerald-100 text-emerald-800 ring-emerald-200',
            'ring' => 'text-emerald-500',
            'text' => 'text-emerald-700',
        ],
        'amber' => [
            'card' => 'border-amber-200 bg-amber-50/60',
            'icon' => 'bg-amber-100 text-amber-700',
            'badge' => 'bg-amber-100 text-amber-800 ring-amber-200',
            'ring' => 'text-amber-500',
            'text' => 'text-amber-700',
        ],
        'red' => [
            'card' => 'border-red-200 bg-red-50/60',
            'icon' => 'bg-red-100 text-red-700',
            'badge' => 'bg-red-100 text-red-800 ring-red-200',
            'ring' => 'text-red-500',
            'text' => 'text-red-700',
        ],
        default => [
            'card' => 'border-gray-200 bg-gray-50',
            'icon' => 'bg-gray-100 text-gray-600',
            'badge' => 'bg-gray-100 text-gray-700 ring-gray-200',
            'ring' => 'text-gray-400',
            'text' => 'text-gray-600',
        ],
    };

    $scoreDash = $score === null ? 0 : round(($score / 100) * 251.2, 1);
@endphp

<x-app-layout
    title="Candidate Analysis Report"
    description="A structured summary of this candidate's role match."
>
    <div data-analysis-report class="mx-auto max-w-6xl space-y-7">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div class="min-w-0">
                <a href="/analyses" class="mb-4 inline-flex min-h-9 items-center gap-2 rounded-lg pr-3 text-sm font-medium text-gray-500 transition hover:text-indigo-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M19 12H5m6 6-6-6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Back to History
                </a>
                <h2 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">Candidate Analysis Report</h2>
                <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-gray-500">
                    <span class="font-medium text-gray-700">{{ $candidateName }}</span>
                    <span class="hidden size-1 rounded-full bg-gray-300 sm:inline-block" aria-hidden="true"></span>
                    <span>
                        @if ($createdAt instanceof \DateTimeInterface)
                            Analyzed {{ $createdAt->format('M j, Y') }}
                        @else
                            Analysis date unavailable
                        @endif
                    </span>
                </div>
            </div>
            <a
                href="/analyses/create"
                class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2"
            >
                <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                New Analysis
            </a>
        </div>

        <section class="grid gap-5 lg:grid-cols-[minmax(0,1.35fr)_minmax(280px,0.65fr)]" aria-label="Match score summary">
            <div class="flex flex-col justify-between gap-6 rounded-2xl border border-gray-200/80 bg-white p-6 shadow-sm shadow-gray-200/40 sm:flex-row sm:items-center sm:p-8">
                <div class="flex items-center gap-5 sm:gap-7">
                    <div class="relative size-32 shrink-0 sm:size-36">
                        <svg class="size-full -rotate-90" viewBox="0 0 100 100" role="img" aria-label="{{ $score !== null ? "Match score {$score} out of 100" : 'Match score unavailable' }}">
                            <circle cx="50" cy="50" r="40" fill="none" stroke="currentColor" stroke-width="8" class="text-gray-100"/>
                            <circle
                                cx="50"
                                cy="50"
                                r="40"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="8"
                                stroke-linecap="round"
                                stroke-dasharray="{{ $scoreDash }} 251.2"
                                class="{{ $scoreToneClasses['ring'] }} transition-[stroke-dasharray] duration-500"
                            />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-3xl font-semibold tracking-tight text-gray-900">{{ $score !== null ? $score : '—' }}<span class="text-lg text-gray-500">{{ $score !== null ? '%' : '' }}</span></span>
                            <span class="mt-0.5 text-[11px] font-medium uppercase tracking-wide text-gray-400">Match score</span>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-500">Overall assessment</p>
                        <h3 class="mt-2 text-xl font-semibold tracking-tight text-gray-900 sm:text-2xl">{{ $scoreLabel }}</h3>
                        <p class="mt-2 max-w-md text-sm leading-6 text-gray-500">{{ $scoreDescription }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 self-start rounded-full px-3 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $scoreToneClasses['badge'] }}">
                    <span class="size-1.5 rounded-full {{ $scoreTone === 'green' ? 'bg-emerald-500' : ($scoreTone === 'amber' ? 'bg-amber-500' : ($scoreTone === 'red' ? 'bg-red-500' : 'bg-gray-400')) }}" aria-hidden="true"></span>
                    {{ $scoreLabel }}
                </div>
            </div>

            <div class="rounded-2xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white p-6 shadow-sm shadow-gray-200/30 sm:p-7">
                <div class="flex size-10 items-center justify-center rounded-xl bg-white text-indigo-600 shadow-sm ring-1 ring-indigo-100">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="m5 12.5 4.5 4L19 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-sm font-semibold text-gray-900">At a glance</h3>
                <dl class="mt-3 space-y-3">
                    <div class="flex items-center justify-between gap-4 border-b border-indigo-100 pb-2.5">
                        <dt class="text-sm text-gray-500">Matching skills</dt>
                        <dd class="text-sm font-semibold text-gray-900">{{ count($matchingSkills) }} <span class="font-normal text-gray-400">of 5</span></dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 border-b border-indigo-100 pb-2.5">
                        <dt class="text-sm text-gray-500">Skill gaps</dt>
                        <dd class="text-sm font-semibold text-gray-900">{{ count($skillGaps) }} <span class="font-normal text-gray-400">of 3</span></dd>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-sm text-gray-500">Interview questions</dt>
                        <dd class="text-sm font-semibold text-gray-900">{{ count($interviewQuestions) }} <span class="font-normal text-gray-400">of 3</span></dd>
                    </div>
                </dl>
            </div>
        </section>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-sm shadow-gray-200/40" aria-labelledby="matching-skills-heading">
                <div class="flex items-center justify-between gap-4 border-b border-gray-100 px-5 py-5 sm:px-6">
                    <div class="flex items-center gap-3">
                        <span class="flex size-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 ring-1 ring-inset ring-emerald-100">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="m5 12.5 4.5 4L19 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <div>
                            <h3 id="matching-skills-heading" class="text-sm font-semibold text-gray-900">Matching Skills</h3>
                            <p class="mt-0.5 text-xs text-gray-500">Strengths aligned with the role</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">{{ count($matchingSkills) }} / 5</span>
                </div>
                @if (count($matchingSkills))
                    <ul class="divide-y divide-gray-100 px-5 sm:px-6">
                        @foreach ($matchingSkills as $skill)
                            <li class="flex min-w-0 items-start gap-3 py-3.5">
                                <span class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700" aria-hidden="true">
                                    <svg class="size-3" viewBox="0 0 16 16" fill="none"><path d="m3.5 8 3 3 6-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </span>
                                <span class="min-w-0 break-words text-sm font-medium text-gray-700">{{ is_scalar($skill) ? $skill : 'Skill unavailable' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="px-6 py-8 text-center text-sm text-gray-500">No matching skills are available for this report.</p>
                @endif
            </section>

            <section class="overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-sm shadow-gray-200/40" aria-labelledby="skill-gaps-heading">
                <div class="flex items-center justify-between gap-4 border-b border-gray-100 px-5 py-5 sm:px-6">
                    <div class="flex items-center gap-3">
                        <span class="flex size-9 items-center justify-center rounded-xl bg-amber-50 text-amber-600 ring-1 ring-inset ring-amber-100">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 8v5M12 16.5h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M10.3 4.5 3.8 16a2 2 0 0 0 1.75 3h12.9a2 2 0 0 0 1.75-3L13.7 4.5a2 2 0 0 0-3.4 0Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <div>
                            <h3 id="skill-gaps-heading" class="text-sm font-semibold text-gray-900">Skill Gaps</h3>
                            <p class="mt-0.5 text-xs text-gray-500">Areas to explore further</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">{{ count($skillGaps) }} / 3</span>
                </div>
                @if (count($skillGaps))
                    <ul class="divide-y divide-gray-100 px-5 sm:px-6">
                        @foreach ($skillGaps as $gap)
                            <li class="flex min-w-0 items-start gap-3 py-3.5">
                                <span class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700" aria-hidden="true">
                                    <svg class="size-3" viewBox="0 0 16 16" fill="none"><path d="M8 3.25v5M8 11.5h.01" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                                </span>
                                <span class="min-w-0 break-words text-sm font-medium text-gray-700">{{ is_scalar($gap) ? $gap : 'Skill gap unavailable' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="px-6 py-8 text-center text-sm text-gray-500">No skill gaps are available for this report.</p>
                @endif
            </section>
        </div>

        <section class="overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-sm shadow-gray-200/40" aria-labelledby="interview-questions-heading">
            <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex items-center gap-3">
                    <span class="flex size-9 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7.5 18.5 4 20l1.2-3.5A8 8 0 1 1 7.5 18.5Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 10h8M8 13.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <div>
                        <h3 id="interview-questions-heading" class="text-sm font-semibold text-gray-900">Suggested Interview Questions</h3>
                        <p class="mt-0.5 text-xs text-gray-500">Use these prompts to guide a focused conversation.</p>
                    </div>
                </div>
                @if (count($interviewQuestions))
                    <button
                        type="button"
                        data-copy-all
                        class="inline-flex min-h-9 items-center justify-center gap-2 self-start rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 sm:self-auto"
                    >
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <rect x="8" y="8" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M16 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2" stroke="currentColor" stroke-width="1.7"/>
                        </svg>
                        Copy all questions
                    </button>
                @endif
            </div>

            @if (count($interviewQuestions))
                <ol class="divide-y divide-gray-100 px-5 sm:px-6">
                    @foreach ($interviewQuestions as $index => $question)
                        <li class="flex min-w-0 flex-col gap-3 py-4 sm:flex-row sm:items-start sm:justify-between sm:gap-5">
                            <div class="flex min-w-0 items-start gap-3">
                                <span class="flex size-7 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-xs font-semibold text-indigo-700">{{ $index + 1 }}</span>
                                <p class="min-w-0 break-words pt-1 text-sm leading-6 text-gray-700">{{ is_scalar($question) ? $question : 'Interview question unavailable' }}</p>
                            </div>
                            <div class="flex shrink-0 items-center gap-2 self-end sm:self-start">
                                <span data-copy-status class="text-xs text-emerald-700" aria-live="polite"></span>
                                <button
                                    type="button"
                                    data-copy-question
                                    data-question-text="{{ is_scalar($question) ? $question : '' }}"
                                    aria-label="Copy question {{ $index + 1 }}"
                                    class="inline-flex size-9 items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-indigo-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
                                >
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <rect x="8" y="8" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/>
                                        <path d="M16 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2" stroke="currentColor" stroke-width="1.7"/>
                                    </svg>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ol>
                <p data-copy-all-status class="sr-only" aria-live="polite"></p>
            @else
                <p class="px-6 py-8 text-center text-sm text-gray-500">No interview questions are available for this report.</p>
            @endif
        </section>

        <x-alert type="info" class="mb-0">
            AI-generated recommendations are intended to support HR decision-making and should not be treated as the sole basis for hiring decisions.
        </x-alert>
    </div>
</x-app-layout>
