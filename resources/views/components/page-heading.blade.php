@props([
    'title',
    'description' => null,
])

<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="max-w-2xl">
        <h2 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">{{ $title }}</h2>
        @if ($description)
            <p class="mt-2 text-sm leading-6 text-gray-500 sm:text-base">{{ $description }}</p>
        @endif
    </div>
    @if (isset($actions))
        <div class="flex shrink-0 items-center gap-3">
            {{ $actions }}
        </div>
    @endif
</div>
