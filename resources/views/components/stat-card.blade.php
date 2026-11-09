@props([
    'label',
    'value',
    'detail' => null,
    'icon' => null,
    'tone' => 'indigo',
])

@php
    $iconClasses = match ($tone) {
        'green' => 'bg-emerald-50 text-emerald-600 ring-emerald-100',
        'amber' => 'bg-amber-50 text-amber-600 ring-amber-100',
        'red' => 'bg-red-50 text-red-600 ring-red-100',
        default => 'bg-indigo-50 text-indigo-600 ring-indigo-100',
    };
@endphp

<section class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-sm shadow-gray-200/40 sm:p-6" aria-label="{{ $label }}">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $value }}</p>
            @if ($detail)
                <p class="mt-2 text-xs leading-5 text-gray-500">{{ $detail }}</p>
            @endif
        </div>
        @if ($icon)
            <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-xl ring-1 ring-inset {{ $iconClasses }}">
                {{ $icon }}
            </span>
        @endif
    </div>
</section>
