<x-app-layout
    title="Analysis History"
    description="Review, search, and filter previously analyzed candidates."
>
    @php
        $searchValue = request('search', '');
        $minScoreValue = request('min_score', '');
        $maxScoreValue = request('max_score', '');
        $search = is_string($searchValue) || is_numeric($searchValue) ? (string) $searchValue : '';
        $minScore = is_string($minScoreValue) || is_numeric($minScoreValue) ? (string) $minScoreValue : '';
        $maxScore = is_string($maxScoreValue) || is_numeric($maxScoreValue) ? (string) $maxScoreValue : '';
        $hasFilters = filled($search) || filled($minScore) || filled($maxScore);
    @endphp

    <div class="mx-auto max-w-7xl space-y-7">
        <x-page-heading
            title="Analysis History"
            description="Review, search, and filter previously analyzed candidates."
        >
            <x-slot:actions>
                <a
                    href="/analyses/create"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2"
                >
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    New Analysis
                </a>
            </x-slot:actions>
        </x-page-heading>

        <section class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-sm shadow-gray-200/40 sm:p-6" aria-label="Search and filter analyses">
            <form action="/history" method="GET" data-history-filter-form class="space-y-5">
                <div class="grid gap-5 lg:grid-cols-[minmax(260px,1.3fr)_minmax(0,1fr)] lg:items-end">
                    <div>
                        <label for="history-search" class="mb-2 block text-sm font-medium text-gray-700">Search candidates</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="1.7"/>
                                <path d="m16 16 4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                            </svg>
                            <input
                                id="history-search"
                                type="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Search by candidate name..."
                                class="block min-h-11 w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-12 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 hover:border-gray-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10"
                            >
                            <button
                                type="button"
                                data-clear-history-search
                                aria-label="Clear candidate search"
                                @disabled(! filled($search))
                                class="absolute right-2 top-1/2 inline-flex size-8 -translate-y-1/2 items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 disabled:pointer-events-none disabled:opacity-0"
                            >
                                <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="m7 7 10 10M17 7 7 17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <fieldset class="min-w-0">
                        <legend class="mb-2 text-sm font-medium text-gray-700">Match score range</legend>
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                            <div class="grid flex-1 grid-cols-2 gap-3">
                                <div>
                                    <label for="min-score" class="mb-1.5 block text-xs font-medium text-gray-500">Minimum Score</label>
                                    <input
                                        id="min-score"
                                        name="min_score"
                                        type="number"
                                        min="0"
                                        max="100"
                                        step="1"
                                        value="{{ $minScore }}"
                                        inputmode="numeric"
                                        placeholder="0"
                                        data-min-score
                                        class="block min-h-11 w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 hover:border-gray-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10"
                                    >
                                </div>
                                <div>
                                    <label for="max-score" class="mb-1.5 block text-xs font-medium text-gray-500">Maximum Score</label>
                                    <input
                                        id="max-score"
                                        name="max_score"
                                        type="number"
                                        min="0"
                                        max="100"
                                        step="1"
                                        value="{{ $maxScore }}"
                                        inputmode="numeric"
                                        placeholder="100"
                                        data-max-score
                                        class="block min-h-11 w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 hover:border-gray-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10"
                                    >
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2"
                            >
                                <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M4 5h16l-6.5 7.5v5L10.5 19v-6.5L4 5Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Apply Filters
                            </button>
                        </div>
                        <p data-score-filter-error class="mt-2 hidden text-sm text-red-600" role="alert"></p>
                    </fieldset>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 pt-4">
                    <p class="text-xs text-gray-500">Search by name or narrow results to a match score range.</p>
                    <a href="/history" class="inline-flex min-h-9 items-center gap-1.5 rounded-lg px-3 text-sm font-semibold text-gray-500 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                        Reset Filters
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4.5 12a7.5 7.5 0 1 0 2.2-5.3L4.5 9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4.5 4.75V9h4.25" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </form>
        </section>

        @if ($analyses->isNotEmpty())
            <section aria-label="Analysis results">
                <div class="mb-3 flex items-center justify-between gap-3">
                    <p class="text-sm text-gray-500">
                        Showing <span class="font-semibold text-gray-700">{{ $analyses->firstItem() }}–{{ $analyses->lastItem() }}</span>
                        of <span class="font-semibold text-gray-700">{{ $analyses->total() }}</span> {{ \Illuminate\Support\Str::plural('analysis', $analyses->total()) }}
                    </p>
                    @if ($hasFilters)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
                            <span class="size-1.5 rounded-full bg-indigo-500" aria-hidden="true"></span>
                            Filters applied
                        </span>
                    @endif
                </div>

                <div class="overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-sm shadow-gray-200/40">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[980px] text-left">
                            <caption class="sr-only">Previously completed resume analyses</caption>
                            <thead class="border-b border-gray-200 bg-gray-50/80">
                                <tr>
                                    <th scope="col" class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wide text-gray-500 sm:px-6">Candidate</th>
                                    <th scope="col" class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Match Score</th>
                                    <th scope="col" class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Matching Skills</th>
                                    <th scope="col" class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Skill Gaps</th>
                                    <th scope="col" class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Date</th>
                                    <th scope="col" class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($analyses as $analysis)
                                    @php
                                        $score = is_numeric($analysis->match_score ?? null)
                                            ? max(0, min(100, (int) $analysis->match_score))
                                            : null;
                                        $scoreClasses = match (true) {
                                            $score === null => 'bg-gray-100 text-gray-600 ring-gray-200',
                                            $score >= 80 => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                            $score >= 50 => 'bg-amber-50 text-amber-700 ring-amber-200',
                                            default => 'bg-red-50 text-red-700 ring-red-200',
                                        };
                                        $skills = is_array($analysis->matching_skills ?? null) ? array_slice($analysis->matching_skills, 0, 3) : [];
                                        $gaps = is_array($analysis->skill_gaps ?? null) ? array_slice($analysis->skill_gaps, 0, 2) : [];
                                    @endphp
                                    <tr class="transition hover:bg-gray-50/70">
                                        <th scope="row" class="max-w-[220px] px-5 py-4 text-sm font-semibold text-gray-900 sm:px-6">
                                            <span class="block break-words">{{ $analysis->candidate_name ?: 'Candidate' }}</span>
                                        </th>
                                        <td class="whitespace-nowrap px-5 py-4">
                                            <span class="inline-flex min-w-16 items-center justify-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $scoreClasses }}">
                                                {{ $score !== null ? "{$score}%" : '—' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex max-w-xs flex-wrap gap-1.5">
                                                @forelse ($skills as $skill)
                                                    <span class="max-w-[150px] truncate rounded-md border border-gray-200 bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600" title="{{ is_scalar($skill) ? $skill : '' }}">{{ is_scalar($skill) ? $skill : 'Skill unavailable' }}</span>
                                                @empty
                                                    <span class="text-sm text-gray-400">—</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex max-w-xs flex-wrap gap-1.5">
                                                @forelse ($gaps as $gap)
                                                    <span class="max-w-[150px] truncate rounded-md border border-amber-100 bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700" title="{{ is_scalar($gap) ? $gap : '' }}">{{ is_scalar($gap) ? $gap : 'Gap unavailable' }}</span>
                                                @empty
                                                    <span class="text-sm text-gray-400">—</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">
                                            {{ $analysis->created_at instanceof \DateTimeInterface ? $analysis->created_at->format('M j, Y') : '—' }}
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right">
                                            <a href="{{ url('/analyses/'.$analysis->id) }}" class="inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg px-3 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                                                View Report
                                                <svg class="size-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                    <path d="M7 17 17 7M8 7h9v9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <span class="sr-only">for {{ $analysis->candidate_name ?: 'candidate' }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="border-t border-gray-100 px-5 py-3 text-xs text-gray-400 sm:hidden">Swipe horizontally to see all analysis details.</p>
                </div>

                @if ($analyses->hasPages())
                    <nav class="mt-5" aria-label="Analysis history pagination">
                        {{ $analyses->withQueryString()->links() }}
                    </nav>
                @endif
            </section>
        @elseif ($hasFilters)
            <x-empty-state
                title="No candidates found matching your filters."
                description="Try adjusting your search or score range to see more results."
            >
                <x-slot:actions>
                    <a href="/history" class="inline-flex min-h-10 items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                        Clear Filters
                    </a>
                </x-slot:actions>
            </x-empty-state>
        @else
            <x-empty-state
                title="Your analysis history is empty."
                description="Completed resume analyses will appear here. Start a screening to build your candidate history."
            >
                <x-slot:actions>
                    <a href="/analyses/create" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                        Start New Analysis
                    </a>
                </x-slot:actions>
            </x-empty-state>
        @endif
        <p data-history-filter-status class="sr-only" aria-live="polite"></p>
    </div>
</x-app-layout>
