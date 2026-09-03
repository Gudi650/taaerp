<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Goodness Group</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    @stack('head')
</head>
<body class="bg-white text-slate-800 font-sans @yield('bodyClass')">
    @php
        $pageTitle = trim($__env->yieldContent('title')) ?: 'Dashboard';
    @endphp

    @include('components.topbar')
    @include('components.sidebar')
    @include('components.modal')
    @include('components.alert')
    @include('components.confirm')
    @include('components.action-feedback')

    @yield('content')

    @stack('scripts')
</body>
</html>
