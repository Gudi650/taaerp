<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sign in') — {{ company_name() }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
            background: #e7eef3;
        }
        .auth-card {
            width: 420px;
            max-width: 100%;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #0e4060;
            box-shadow: 0 1px 3px rgba(14, 64, 96, 0.08);
            padding: 2rem 2rem 2.25rem;
        }
        .auth-input:focus { box-shadow: inset 3px 0 0 #0e4060; }
        .auth-input.input-error:focus { box-shadow: inset 3px 0 0 #dc2626; }
    </style>
    @stack('head')
</head>
<body class="auth-page text-slate-800 font-sans">
    <div class="auth-card">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-brand-600 flex items-center justify-center shrink-0">
                <img src="{{ asset('favicon.png') }}" alt="{{ company_name() }} logo" class="w-6 h-6 object-contain brightness-0 invert" />
            </div>
            <div>
                <p class="font-display font-semibold text-brand-700 leading-none">{{ company_name() }}</p>
                <p class="mt-1 text-[11px] uppercase tracking-[0.18em] text-slate-500">{{ company_tagline() }}</p>
            </div>
        </div>

        @yield('content')
    </div>

    @include('components.alert')
    @stack('scripts')
</body>
</html>
