<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset('assets/images/simian-safaris-logo.ico') }}" type="image/x-icon">

        <!-- Scripts / Styles -->
        @vite('resources/css/app.css')

        @isset($extra_head)
            {{ $extra_head }}
        @else
            <title>Simian Safaris</title>
        @endisset
    </head>
    <body>
        <livewire:partials.flash-messages />

        <main class="app_layout">
            <livewire:partials.app-navbar />

            <div class="app_layout_container">
                {{ $slot }}
            </div>
        </main>

        {{-- Livewire --}}
        @livewireScripts

        {{-- Dynamic Scripts --}}
        @isset($scripts)
            {{ $scripts }}
        @endisset
        @stack('scripts')

        @isset($afterScripts)
            {{ $afterScripts }}
        @endisset
        @stack('after-scripts')
    </body>
</html>
