@extends('layouts.guest')

@section('title', 'Sign in')

@section('content')
    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-brand-600 mb-2">Welcome back</p>
    <h1 class="font-display text-[1.85rem] font-semibold text-brand-700 mb-2">Sign in</h1>
    <p class="text-sm text-slate-500 leading-relaxed mb-8">Enter your work email and password to open {{ company_name() }}.</p>

    @if ($errors->any())
        <div class="mb-6 text-sm text-red-800 bg-red-50 border-l-4 border-red-600 px-4 py-3">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}" onsubmit="return showLoader(event, 'loginLoader')" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-slate-600 mb-2">Email</label>
            <input id="email" type="email" name="email" placeholder="you@company.com" value="{{ old('email') }}" autocomplete="email"
                class="auth-input w-full h-12 px-3.5 border border-slate-300 bg-brand-50 text-slate-900 placeholder:text-slate-400 outline-none transition-colors focus:bg-white focus:border-brand-600 @error('email') input-error border-red-500 bg-red-50 @enderror"
                required />
            @error('email')<p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="text-xs font-semibold uppercase tracking-wide text-slate-600">Password</label>
            </div>
            <div class="relative">
                <input id="password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password"
                    class="auth-input w-full h-12 px-3.5 pr-11 border border-slate-300 bg-brand-50 text-slate-900 placeholder:text-slate-400 outline-none transition-colors focus:bg-white focus:border-brand-600 @error('password') input-error border-red-500 bg-red-50 @enderror"
                    required />
                <x-password-toggle for="password" />
            </div>
            @error('password')<p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="w-full h-12 bg-brand-600 text-white font-display font-semibold tracking-wide hover:bg-brand-700 transition-colors">
            Sign in
        </button>
    </form>

    <div class="mt-8 pt-6 border-t border-slate-200 flex items-center justify-between gap-4">
        <p class="text-sm text-slate-500">New here?</p>
        <a href="{{ url('/signup') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700 underline underline-offset-4 decoration-brand-200 hover:decoration-brand-600">Create an account</a>
    </div>

    <x-loading id="loginLoader" size="lg" color="brand" full-page="true" message="Signing you in..." :show="false" />
@endsection

@push('scripts')
<script>
    function showLoader(event, loaderId) {
        event.preventDefault();
        const loader = document.getElementById(loaderId);
        const form = event.currentTarget;
        if (loader) { loader.classList.remove('hidden'); loader.classList.add('flex'); }
        setTimeout(() => form.submit(), 75);
        return true;
    }
</script>
@endpush
