@extends('layouts.guest')

@section('title', 'Sign Up')

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

            <h2 class="text-2xl font-semibold text-slate-800 mb-4">Create your account</h2>

            {{-- Show validation errors returned from the backend --}}
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-md px-3 py-2">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Show success messages if the controller sends one --}}
            @if (session('success'))
                <div class="mb-4 text-sm text-brand-700 bg-brand-50 border border-brand-200 rounded-md px-3 py-2">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Signup form - submits to Laravel backend --}}
            <form method="POST" action="{{ route('signup.submit') }}" class="space-y-4">
                {{-- CSRF protection is required for all POST forms in Laravel --}}
                @csrf

                <div>
                    <label for="name" class="block text-sm text-slate-500 mb-2">Full Name</label>
                    <input id="name" name="name" type="text" placeholder="Hamis Juma" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-md bg-white text-slate-800 outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 @error('name') border-red-500 @enderror"
                        required />
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm text-slate-500 mb-2">Email</label>
                    <input id="email" name="email" type="email" placeholder="you@company.tz" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-md bg-white text-slate-800 outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 @error('email') border-red-500 @enderror"
                            class="w-full px-4 py-2 border border-slate-300 rounded-md bg-white text-slate-800 outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 @error('email') border-red-500 @enderror"
                        required />
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm text-slate-500 mb-2">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" placeholder="At least 6 characters"
                            class="w-full px-4 py-2 border border-slate-300 rounded-md bg-white text-slate-800 outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 @error('password') border-red-500 @enderror"
                                class="w-full px-4 py-2 border border-slate-300 rounded-md bg-white text-slate-800 outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 @error('password') border-red-500 @enderror"
                            required />
                        <button id="togglePassword" type="button" class="absolute right-2 top-2 text-sm text-slate-500">Show</button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm text-slate-500 mb-2">Confirm Password</label>
                    <div class="relative">
                        <input id="passwordConfirm" name="password_confirmation" type="password" placeholder="Re-enter password"
                            class="w-full px-4 py-2 border border-slate-300 rounded-md bg-white text-slate-800 outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600"
                                class="w-full px-4 py-2 border border-slate-300 rounded-md bg-white text-slate-800 outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600"
                            required />
                        <button id="togglePasswordConfirm" type="button" class="absolute right-2 top-2 text-sm text-slate-500">Show</button>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full px-4 py-2 bg-brand-600 text-white rounded-md font-medium">Sign Up</button>
                </div>
            </form>

            <p class="text-sm text-slate-500 mt-6 text-center">
                Already have an account?
                <a href="/login" class="text-brand-700 hover:text-brand-600 font-medium">Sign in</a>
            </p>
        </div>
        <p class="text-center text-sm text-slate-500 mt-4">Goodness Group - Multi-company ERP</p>
    </div>

    <script>
        // Password field toggle for the main password input
        const passwordInput = document.getElementById('password');
        // Password field toggle for the confirmation input
        const confirmPasswordInput = document.getElementById('passwordConfirm');
        // Buttons that control the password visibility
        const togglePasswordBtn = document.getElementById('togglePassword');
        const toggleConfirmBtn = document.getElementById('togglePasswordConfirm');

        // Show or hide the main password field
        togglePasswordBtn.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordBtn.textContent = 'Hide';
            } else {
                passwordInput.type = 'password';
                togglePasswordBtn.textContent = 'Show';
            }
        });

        // Show or hide the confirmation password field
        toggleConfirmBtn.addEventListener('click', () => {
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                toggleConfirmBtn.textContent = 'Hide';
            } else {
                confirmPasswordInput.type = 'password';
                toggleConfirmBtn.textContent = 'Show';
            }
        });
    </script>
@endsection
