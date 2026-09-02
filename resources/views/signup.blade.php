@extends('layouts.guest')

@section('title', 'Create account')

@section('content')
    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-brand-600 mb-2">Get started</p>
    <h1 class="font-display text-[1.85rem] font-semibold text-brand-700 mb-2">Create account</h1>
    <p class="text-sm text-slate-500 leading-relaxed mb-8">Fill in your details to join {{ company_name() }}.</p>

    @if ($errors->any())
        <div class="mb-6 text-sm text-red-800 bg-red-50 border-l-4 border-red-600 px-4 py-3">{{ $errors->first() }}</div>
    @endif

    @if (session('success'))
        <div class="mb-6 text-sm text-brand-700 bg-brand-50 border-l-4 border-brand-600 px-4 py-3">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('signup.submit') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-xs font-semibold uppercase tracking-wide text-slate-600 mb-2">Full name</label>
            <input id="name" name="name" type="text" placeholder="Your full name" value="{{ old('name') }}" autocomplete="name"
                class="auth-input w-full h-12 px-3.5 border border-slate-300 bg-brand-50 text-slate-900 placeholder:text-slate-400 outline-none transition-colors focus:bg-white focus:border-brand-600 @error('name') input-error border-red-500 bg-red-50 @enderror"
                required />
            @error('name')<p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-slate-600 mb-2">Work email</label>
            <input id="email" name="email" type="email" placeholder="you@company.com" value="{{ old('email') }}" autocomplete="email"
                class="auth-input w-full h-12 px-3.5 border border-slate-300 bg-brand-50 text-slate-900 placeholder:text-slate-400 outline-none transition-colors focus:bg-white focus:border-brand-600 @error('email') input-error border-red-500 bg-red-50 @enderror"
                required />
            @error('email')<p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-slate-600 mb-2">Password</label>
            <div class="relative">
                <input id="password" name="password" type="password" placeholder="At least 6 characters" autocomplete="new-password"
                    class="auth-input w-full h-12 px-3.5 pr-11 border border-slate-300 bg-brand-50 text-slate-900 placeholder:text-slate-400 outline-none transition-colors focus:bg-white focus:border-brand-600 @error('password') input-error border-red-500 bg-red-50 @enderror"
                    required />
                <x-password-toggle for="password" />
            </div>
            @error('password')<p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wide text-slate-600 mb-2">Confirm password</label>
            <div class="relative">
                <input id="passwordConfirm" name="password_confirmation" type="password" placeholder="Re-enter password" autocomplete="new-password"
                    class="auth-input w-full h-12 px-3.5 pr-11 border border-slate-300 bg-brand-50 text-slate-900 placeholder:text-slate-400 outline-none transition-colors focus:bg-white focus:border-brand-600"
                    required />
                <x-password-toggle for="passwordConfirm" />
            </div>
        </div>

        <button type="submit" class="w-full h-12 bg-brand-600 text-white font-display font-semibold tracking-wide hover:bg-brand-700 transition-colors">
            Create account
        </button>
    </form>

    <div class="mt-8 pt-6 border-t border-slate-200 flex items-center justify-between gap-4">
        <p class="text-sm text-slate-500">Already registered?</p>
        <a href="{{ url('/login') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700 underline underline-offset-4 decoration-brand-200 hover:decoration-brand-600">Sign in</a>
    </div>
@endsection
