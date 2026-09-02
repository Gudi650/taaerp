@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md mx-auto p-6">
        <div class="bg-white border border-slate-200 shadow-sm rounded-lg p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-md overflow-hidden border border-brand-600 bg-white flex items-center justify-center" aria-hidden>
                    <img src="{{ asset('favicon.png') }}" alt="Goodness Group logo" class="w-8 h-8 object-contain logo-brand" />
                </div>
                <div>
                    <div class="text-sm font-semibold text-slate-800">Goodness Group</div>
                    <div class="text-xs text-slate-500">Enterprise Management System</div>
                </div>
            </div>

            <h2 class="text-2xl font-semibold text-slate-800 mb-4">Sign in to your account</h2>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-md px-3 py-2">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" onsubmit="return showLoader(event, 'loginLoader')" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm text-slate-500 mb-2">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        placeholder="you@company.tz"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-md bg-white text-slate-800 outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 @error('email') border-red-500 @enderror"
                        required
                    />
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm text-slate-500 mb-2">Password</label>
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full px-4 py-2 border border-slate-300 rounded-md bg-white text-slate-800 outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 @error('password') border-red-500 @enderror"
                            required
                        />
                        <button
                            id="togglePwd"
                            type="button"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-sm font-medium text-slate-500 hover:text-slate-700 transition"
                        >
                            Show
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full px-4 py-2.5 bg-brand-600 text-white rounded-md font-medium hover:bg-brand-700 transition focus:outline-none focus:ring-2 focus:ring-brand-600 focus:ring-offset-2"
                    >
                        Sign In
                    </button>
                </div>
            </form>

            <p class="text-sm text-slate-500 mt-6 text-center">
                Need an account?
                <a href="/signup" class="text-brand-700 hover:text-brand-600 font-medium">Create one</a>
            </p>
        </div>
        <p class="text-center text-sm text-slate-500 mt-4">Goodness Group — Multi-company ERP</p>
    </div>

    <x-loading id="loginLoader" size="lg" color="amber" full-page="true" message="Signing you in..." :show="false" />
<script>
        function showLoader(event, loaderId) {
            if (event) {
                event.preventDefault();
            }

            const loader = document.getElementById(loaderId);
            const form = event?.currentTarget || event?.target;

            if (loader) {
                loader.classList.remove('hidden');
                loader.classList.add('flex');
            }

            setTimeout(() => {
                if (form) {
                    form.submit();
                }
            }, 75);

            return true;
        }

        const toggle = document.getElementById('togglePwd');
        const pwd = document.getElementById('password');

        if (toggle && pwd) {
            toggle.addEventListener('click', () => {
                if (pwd.type === 'password') {
                    pwd.type = 'text';
                    toggle.textContent = 'Hide';
                } else {
                    pwd.type = 'password';
                    toggle.textContent = 'Show';
                }
            });
        }
    </script>
@endsection
