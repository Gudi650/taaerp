@props([
    'active' => 'login',
])

@php
    $tabBase = 'text-sm pb-1 border-b transition-colors';
    $tabActive = 'text-white border-white';
    $tabIdle = 'text-white/55 border-transparent hover:text-white/80';
@endphp

<div {{ $attributes->class('w-full max-w-[22rem] bg-[rgb(14,64,96)]/85 backdrop-blur-[6px] shadow-2xl px-8 pt-8 pb-7') }}>
    <nav class="flex items-center gap-6 mb-8" aria-label="Authentication">
        <a href="{{ route('login') }}" class="{{ $tabBase }} {{ $active === 'login' ? $tabActive : $tabIdle }}">Login</a>
        <a href="{{ route('signup') }}" class="{{ $tabBase }} {{ $active === 'register' ? $tabActive : $tabIdle }}">Register</a>
    </nav>

    {{ $slot }}
</div>
