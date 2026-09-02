<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sign in') — Goodness Group</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    @stack('head')
</head>
<body class="min-h-screen bg-white text-slate-800 font-sans flex flex-col">
    <header class="h-16 bg-brand-600 flex items-center px-6">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-md overflow-hidden border border-white/20 bg-white flex items-center justify-center">
                <img src="{{ asset('favicon.png') }}" alt="Goodness Group logo" class="w-6 h-6 object-contain logo-brand" />
            </div>
            <span class="text-white font-display font-semibold text-sm">Goodness Group</span>
        </div>
    </header>

    <div class="flex-1 flex items-center justify-center p-6">
        @yield('content')
    </div>

    @include('components.alert')

    @stack('scripts')
</body>
</html>
