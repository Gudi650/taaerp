@extends('layouts.app')

@section('title', 'Users')

@section('content')

<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">
    <nav class="inline-flex bg-white shadow-sm mb-6">
        <button type="button" id="tabUsersBtn" class="flex items-center gap-2 h-9 px-3 text-sm font-medium font-display bg-brand-600 text-white">
            Users <span class="px-1.5 py-0.5 text-[11px] font-semibold bg-white text-brand-700">{{ $users->count() }}</span>
        </button>
        <button type="button" id="tabRolesBtn" class="flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700">
            Roles <span class="px-1.5 py-0.5 text-[11px] font-semibold bg-brand-50 text-brand-700">{{ $roles->count() }}</span>
        </button>
    </nav>

    @include('users.list')
    @include('users.roles')
    
</main>

@include('users.modals.assign-role')
@include('users.modals.create-role')
@include('users.modals.edit-role')
@include('users.modals.assign-company')
@include('users-scripts')
@endsection
