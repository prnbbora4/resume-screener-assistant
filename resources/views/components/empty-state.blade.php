@props([
    'title',
    'description',
])

<div {{ $attributes->class(['rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-12 text-center sm:px-10']) }}>
    <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
        @if (isset($icon))
            {{ $icon }}
        @else
            <svg class="size-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M7 3.75h7.25L19 8.5v11.75H7a2 2 0 0 1-2-2v-12.5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                <path d="M14 4v5h5M8.5 13h7M8.5 16.5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        @endif
    </div>
    <h3 class="mt-5 text-base font-semibold text-gray-900">{{ $title }}</h3>
    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">{{ $description }}</p>
    @if (isset($actions))
        <div class="mt-6 flex justify-center">
            {{ $actions }}
        </div>
    @endif
</div>
