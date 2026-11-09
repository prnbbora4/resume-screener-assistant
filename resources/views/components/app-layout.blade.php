@props([
    'title' => config('app.name', 'Resume Screener Assistant'),
    'description' => 'Your workspace for thoughtful, data-informed hiring.',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} · Resume Screener Assistant</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-50 font-sans text-gray-900 antialiased">
        <div class="min-h-screen">
            <div
                data-sidebar-overlay
                class="fixed inset-0 z-40 hidden bg-gray-950/50 backdrop-blur-sm lg:hidden"
                aria-hidden="true"
            ></div>

            <x-sidebar />

            <div class="min-h-screen lg:pl-72">
                <x-header :title="$title" :description="$description" />

                <main id="main-content" class="mx-auto w-full max-w-[1600px] px-4 py-6 sm:px-6 lg:px-10 lg:py-9">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
