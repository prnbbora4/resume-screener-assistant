@props([
    'type' => 'info',
    'message' => null,
])

@php
    $alertClasses = match ($type) {
        'success' => 'border-emerald-200 bg-emerald-50 text-emerald-900',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-900',
        'error', 'danger' => 'border-red-200 bg-red-50 text-red-900',
        default => 'border-indigo-200 bg-indigo-50 text-indigo-900',
    };

    $iconClasses = match ($type) {
        'success' => 'text-emerald-600',
        'warning' => 'text-amber-600',
        'error', 'danger' => 'text-red-600',
        default => 'text-indigo-600',
    };
@endphp

<div
    {{ $attributes->class(['mb-6 flex items-start gap-3 rounded-xl border px-4 py-3.5 text-sm shadow-sm shadow-gray-200/30', $alertClasses]) }}
    role="{{ in_array($type, ['error', 'danger', 'warning'], true) ? 'alert' : 'status' }}"
>
    <svg class="mt-0.5 size-5 shrink-0 {{ $iconClasses }}" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        @if ($type === 'success')
            <path d="m5 12.5 4.5 4L19 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
        @elseif ($type === 'error' || $type === 'danger')
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
            <path d="M12 8v5M12 16.5h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        @elseif ($type === 'warning')
            <path d="m12 3.75 9 16H3l9-16Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
            <path d="M12 9v4M12 16.5h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        @else
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
            <path d="M12 11v5M12 8h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        @endif
    </svg>
    <p class="leading-6">{{ $message ?? $slot }}</p>
</div>
