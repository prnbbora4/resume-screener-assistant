@props([
    'title' => 'Dashboard',
    'description' => 'Your workspace for thoughtful, data-informed hiring.',
])

<header class="sticky top-0 z-30 border-b border-gray-200/80 bg-white/90 backdrop-blur-xl">
    <div class="flex min-h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-10">
        <div class="flex min-w-0 items-center gap-3">
            <button
                type="button"
                class="inline-flex size-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-600 shadow-sm transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 lg:hidden"
                data-sidebar-toggle
                aria-label="Open navigation"
                aria-controls="app-sidebar"
                aria-expanded="false"
            >
                <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M4 6.5h16M4 12h16M4 17.5h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </button>
            <div class="min-w-0">
                <h1 class="truncate text-lg font-semibold tracking-tight text-gray-900 sm:text-xl">{{ $title }}</h1>
                <p class="mt-0.5 hidden truncate text-sm text-gray-500 sm:block">{{ $description }}</p>
            </div>
        </div>

        <div class="flex shrink-0 items-center gap-3 sm:gap-4">
            <div class="hidden h-8 w-px bg-gray-200 sm:block" aria-hidden="true"></div>
            <div class="flex items-center gap-3">
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-semibold text-gray-800">HR Team</p>
                    <p class="text-xs text-gray-500">Recruitment workspace</p>
                </div>
                <div class="flex size-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700 ring-4 ring-indigo-50" aria-label="HR profile placeholder">
                    HR
                </div>
            </div>
        </div>
    </div>
</header>
