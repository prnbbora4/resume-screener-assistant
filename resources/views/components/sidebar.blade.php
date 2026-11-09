@php
    $navigation = [
        [
            'label' => 'Dashboard',
            'href' => '/',
            'active' => request()->is('/'),
            'icon' => 'dashboard',
        ],
        [
            'label' => 'New Analysis',
            'href' => '/analyses/create',
            'active' => request()->is('analyses/create'),
            'icon' => 'plus',
        ],
        [
            'label' => 'Analysis History',
            'href' => '/analyses',
            'active' => request()->is('analyses') || request()->is('analyses/*'),
            'icon' => 'history',
        ],
    ];
@endphp

<aside
    id="app-sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-white/5 bg-gray-900 text-gray-300 shadow-2xl shadow-gray-950/20 transition-transform duration-200 ease-out lg:translate-x-0"
    aria-label="Primary navigation"
>
    <div class="flex h-20 items-center gap-3 border-b border-white/10 px-6">
        <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-indigo-500 text-white shadow-lg shadow-indigo-950/30">
            <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M7 3.75h7.25L19 8.5v11.75H7a2 2 0 0 1-2-2v-12.5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                <path d="M14 4v5h5M8.5 13h7M8.5 16.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="min-w-0">
            <p class="truncate text-sm font-semibold tracking-tight text-white">Resume Screener</p>
            <p class="mt-0.5 text-xs text-gray-400">Assistant</p>
        </div>
        <button
            type="button"
            class="ml-auto inline-flex size-9 items-center justify-center rounded-lg text-gray-400 transition hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 lg:hidden"
            data-sidebar-close
            aria-label="Close navigation"
        >
            <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </button>
    </div>

    <div class="px-4 pt-8">
        <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-gray-500">Workspace</p>
        <nav class="mt-3 space-y-1" aria-label="Workspace">
            @foreach ($navigation as $item)
                <a
                    href="{{ $item['href'] }}"
                    @if ($item['active']) aria-current="page" @endif
                    class="{{ $item['active'] ? 'bg-indigo-500/15 text-white ring-1 ring-inset ring-indigo-400/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400"
                >
                    @if ($item['icon'] === 'dashboard')
                        <svg class="{{ $item['active'] ? 'text-indigo-300' : 'text-gray-500 group-hover:text-gray-300' }} size-5 transition" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <rect x="3.75" y="3.75" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                            <rect x="13.25" y="3.75" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                            <rect x="3.75" y="13.25" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                            <rect x="13.25" y="13.25" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                        </svg>
                    @elseif ($item['icon'] === 'plus')
                        <svg class="{{ $item['active'] ? 'text-indigo-300' : 'text-gray-500 group-hover:text-gray-300' }} size-5 transition" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="12" cy="12" r="8.25" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M12 8v8M8 12h8" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    @else
                        <svg class="{{ $item['active'] ? 'text-indigo-300' : 'text-gray-500 group-hover:text-gray-300' }} size-5 transition" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4.5 12a7.5 7.5 0 1 0 2.2-5.3L4.5 9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4.5 4.75V9h4.25M12 7.5V12l3 1.75" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @endif
                    <span>{{ $item['label'] }}</span>
                    @if ($item['active'])
                        <span class="ml-auto size-1.5 rounded-full bg-indigo-300" aria-hidden="true"></span>
                    @endif
                </a>
            @endforeach
        </nav>
    </div>

    <div class="mt-auto p-4">
        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4">
            <div class="flex items-center gap-2">
                <span class="relative flex size-2">
                    <span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-40"></span>
                    <span class="relative inline-flex size-2 rounded-full bg-emerald-400"></span>
                </span>
                <span class="text-xs font-medium text-gray-300">AI workspace ready</span>
            </div>
            <p class="mt-2 text-xs leading-5 text-gray-500">A clearer view of every candidate, all in one place.</p>
        </div>
        <div class="flex items-center justify-between px-2 pb-1 pt-5 text-xs text-gray-500">
            <span>Resume Screener Assistant</span>
            <span class="rounded-md border border-white/10 px-1.5 py-0.5 font-medium text-gray-400">v1.0</span>
        </div>
    </div>
</aside>
