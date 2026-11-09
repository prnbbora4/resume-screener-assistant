<x-app-layout :title="$title ?? config('app.name', 'Resume Screener Assistant')" :description="$description ?? 'Your workspace for thoughtful, data-informed hiring.'">
    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if (session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    @if (session('status'))
        <x-alert type="info" :message="session('status')" />
    @endif

    @yield('content')
</x-app-layout>
