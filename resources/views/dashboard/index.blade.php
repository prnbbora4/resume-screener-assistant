<x-app-layout
    title="Dashboard"
    description="A clear overview of your candidate screening activity."
>
    @php
        $statistics = $statistics ?? [];
        $recentAnalyses = $recentAnalyses ?? [];
    @endphp

    <div class="space-y-8">
        <section class="relative isolate overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-indigo-600 to-violet-700 px-6 py-8 shadow-xl shadow-indigo-200/50 sm:px-9 sm:py-10 lg:px-11">
            <div class="absolute -right-16 -top-24 -z-10 size-72 rounded-full border-[36px] border-white/[0.07]" aria-hidden="true"></div>
            <div class="absolute -bottom-28 right-36 -z-10 size-56 rounded-full border-[28px] border-white/[0.06]" aria-hidden="true"></div>
            <div class="relative max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-medium text-indigo-50">
                    <span class="size-1.5 rounded-full bg-emerald-300" aria-hidden="true"></span>
                    Your hiring workspace
                </span>
                <h2 class="mt-5 text-2xl font-semibold tracking-tight text-white sm:text-3xl lg:text-4xl">
                    Welcome to Resume Screener Assistant
                </h2>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-indigo-100 sm:text-base sm:leading-7">
                    Analyze resumes against job descriptions, identify relevant skills, and discover candidate suitability with AI-powered insights.
                </p>
                <a
                    href="/analyses/create"
                    class="mt-6 inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-indigo-700 shadow-sm transition hover:bg-indigo-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-indigo-600"
                >
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    Start New Analysis
                </a>
            </div>
        </section>

        <section aria-labelledby="overview-heading">
            <div class="mb-4 flex items-center justify-between gap-4">
                <div>
                    <h2 id="overview-heading" class="text-base font-semibold text-gray-900">Screening overview</h2>
                    <p class="mt-1 text-sm text-gray-500">A snapshot of your candidate evaluations</p>
                </div>
                <span class="hidden rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 sm:inline-flex">
                    Sample data
                </span>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <x-stat-card
                    label="Total Analyses"
                    :value="$statistics['total_analyses'] ?? '—'"
                    detail="Candidates screened"
                    tone="indigo"
                >
                    <x-slot:icon>
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7 3.75h7.25L19 8.5v11.75H7a2 2 0 0 1-2-2v-12.5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                            <path d="M14 4v5h5M8.5 13h7M8.5 16.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </x-slot:icon>
                </x-stat-card>

                <x-stat-card
                    label="Average Match Score"
                    :value="$statistics['average_match_score'] ?? '—'"
                    detail="Across all candidates"
                    tone="amber"
                >
                    <x-slot:icon>
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 17.5 9 12l3.5 3.5L20 7.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.5 7.5H20V13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </x-slot:icon>
                </x-stat-card>

                <x-stat-card
                    label="High Matches"
                    :value="$statistics['high_matches'] ?? '—'"
                    detail="Scores from 80 to 100"
                    tone="green"
                >
                    <x-slot:icon>
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="m5 12.5 4.5 4L19 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/>
                        </svg>
                    </x-slot:icon>
                </x-stat-card>

                <x-stat-card
                    label="Low Matches"
                    :value="$statistics['low_matches'] ?? '—'"
                    detail="Scores from 0 to 49"
                    tone="red"
                >
                    <x-slot:icon>
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 8v5M12 16.5h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M10.3 4.5 3.8 16a2 2 0 0 0 1.75 3h12.9a2 2 0 0 0 1.75-3L13.7 4.5a2 2 0 0 0-3.4 0Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                        </svg>
                    </x-slot:icon>
                </x-stat-card>
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-indigo-100 bg-white shadow-sm shadow-gray-200/40" aria-labelledby="quick-action-heading">
            <div class="flex flex-col gap-6 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-8">
                <div class="flex items-start gap-4">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                        <svg class="size-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7 3.75h7.25L19 8.5v11.75H7a2 2 0 0 1-2-2v-12.5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                            <path d="M14 4v5h5M8.5 13h7M8.5 16.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="max-w-xl">
                        <h2 id="quick-action-heading" class="text-base font-semibold text-gray-900">Ready to screen your next candidate?</h2>
                        <p class="mt-1.5 text-sm leading-6 text-gray-500">Compare a resume with your role requirements and get a structured match report in moments.</p>
                    </div>
                </div>
                <a
                    href="/analyses/create"
                    class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2"
                >
                    Start Analysis
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </section>

        <section aria-labelledby="recent-analyses-heading">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 id="recent-analyses-heading" class="text-base font-semibold text-gray-900">Recent analyses</h2>
                    <p class="mt-1 text-sm text-gray-500">Sample activity for dashboard preview</p>
                </div>
                <a href="/analyses" class="inline-flex min-h-10 items-center gap-1.5 self-start rounded-lg px-3 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 sm:self-auto">
                    View history
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>

            @if (! empty($recentAnalyses))
                <div class="overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-sm shadow-gray-200/40">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[760px] text-left">
                            <caption class="sr-only">Recent resume analysis results</caption>
                            <thead class="border-b border-gray-200 bg-gray-50/80">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Candidate Name</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Match Score</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Matching Skills</th>
                                    <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Date</th>
                                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($recentAnalyses as $analysis)
                                    @php
                                        $score = (int) data_get($analysis, 'match_score', 0);
                                        $scoreClasses = match (true) {
                                            $score >= 80 => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                            $score >= 50 => 'bg-amber-50 text-amber-700 ring-amber-200',
                                            default => 'bg-red-50 text-red-700 ring-red-200',
                                        };
                                    @endphp
                                    <tr class="transition hover:bg-gray-50/70">
                                        <th scope="row" class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-900">
                                            {{ data_get($analysis, 'candidate_name', 'Candidate') }}
                                        </th>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="inline-flex min-w-16 items-center justify-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $scoreClasses }}">
                                                {{ $score }}%
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex max-w-md flex-wrap gap-1.5">
                                                @foreach (array_slice(data_get($analysis, 'matching_skills', []), 0, 3) as $skill)
                                                    <span class="rounded-md border border-gray-200 bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600">{{ $skill }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            {{ data_get($analysis, 'created_at') ? \Illuminate\Support\Carbon::parse(data_get($analysis, 'created_at'))->format('M j, Y') : '—' }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <a href="/analyses/{{ data_get($analysis, 'id') }}" class="inline-flex min-h-9 items-center rounded-lg px-3 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                                                View
                                                <span class="sr-only">analysis for {{ data_get($analysis, 'candidate_name', 'candidate') }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="border-t border-gray-100 px-6 py-3 text-xs text-gray-400 sm:hidden">Swipe horizontally to see all analysis details.</p>
                </div>
            @else
                <x-empty-state
                    title="No analyses yet"
                    description="Your completed candidate screenings will appear here. Start an analysis to see your first match report."
                >
                    <x-slot:actions>
                        <a href="/analyses/create" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            Start your first analysis
                        </a>
                    </x-slot:actions>
                </x-empty-state>
            @endif
        </section>
    </div>
</x-app-layout>
