<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/images/simian-safaris-logo.ico') }}" type="image/x-icon">

    <!-- Scripts / Styles -->
    @vite('resources/css/guest.css')

    @isset($extra_head)
        {{ $extra_head }}
    @else
        <title>Simian Safaris | Best Tour and Travel Company in Nairobi, Kenya</title>
    @endisset
</head>
<body class="antialiased">
    <main class="guest_layout">
        {{ $slot }}
    </main>

    @isset($javascript)
        {{ $javascript }}
    @endisset
</body>
</html>
