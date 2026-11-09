<x-app-layout
    title="Analysis in Progress"
    description="Your candidate report is being prepared."
>
    <div
        data-analysis-status
        data-status-url="{{ route('analyses.status', ['trackingId' => $trackingId]) }}"
        data-processing-url="{{ route('analyses.processing', ['trackingId' => $trackingId]) }}"
        class="mx-auto max-w-3xl"
    >
        <section class="rounded-3xl border border-gray-200/80 bg-white px-6 py-12 text-center shadow-sm shadow-gray-200/40 sm:px-12 sm:py-16">
            <div class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                <svg data-analysis-pending-icon class="size-8 animate-pulse" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 3.75 14.5 9.5l5.75 2.5-5.75 2.5L12 20.25l-2.5-5.75-5.75-2.5L9.5 9.5 12 3.75Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                </svg>
                <svg data-analysis-failed-icon class="hidden size-8 text-red-600" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M12 8v5M12 16.5h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </div>
            <h2 data-analysis-status-heading class="mt-6 text-2xl font-semibold tracking-tight text-gray-900">Your analysis is on its way</h2>
            <p data-analysis-status-message class="mx-auto mt-3 max-w-lg text-sm leading-6 text-gray-500">
                {{ $state['message'] ?? 'Your analysis is queued and will begin shortly.' }}
            </p>
            <div data-analysis-progress class="mx-auto mt-7 flex max-w-xs items-center justify-center gap-2 text-xs font-medium text-indigo-600" role="status" aria-live="polite">
                <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3"/>
                    <path class="opacity-90" fill="currentColor" d="M12 3a9 9 0 0 1 9 9h-3a6 6 0 0 0-6-6V3Z"/>
                </svg>
                <span>Checking for your report…</span>
            </div>
            <a href="{{ route('dashboard') }}" class="mt-8 inline-flex min-h-10 items-center justify-center rounded-xl px-4 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                Return to dashboard
            </a>
        </section>
    </div>
</x-app-layout>
