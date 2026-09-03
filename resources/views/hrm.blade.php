@extends('layouts.app')

@section('title', 'HRM')

@section('content')

@php
    $tabChip = 'px-1.5 py-0.5 text-[11px] font-semibold text-brand-700';
    $counts = [
        'employees' => collect($employees ?? [])->count(),
        'attendance' => 3,
        'leave' => collect($leaves ?? [])->count(),
        'payroll' => collect($salaries ?? [])->count(),
        'departments' => collect($departments ?? [])->count(),
    ];
@endphp

<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">

    <nav class="inline-flex bg-white shadow-sm mb-6 max-w-full overflow-x-auto">
        <button type="button" onclick="switchTab('employees', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display bg-brand-600 text-white shrink-0">
            Employees <span class="{{ $tabChip }} bg-white">{{ $counts['employees'] }}</span>
        </button>
        <button type="button" onclick="switchTab('attendance', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Attendance <span class="{{ $tabChip }} bg-brand-50">{{ $counts['attendance'] }}</span>
        </button>
        <button type="button" onclick="switchTab('leave', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Leave <span class="{{ $tabChip }} bg-brand-50">{{ $counts['leave'] }}</span>
        </button>
        <button type="button" onclick="switchTab('payroll', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Payroll <span class="{{ $tabChip }} bg-brand-50">{{ $counts['payroll'] }}</span>
        </button>
        <button type="button" onclick="switchTab('departments', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Departments <span class="{{ $tabChip }} bg-brand-50">{{ $counts['departments'] }}</span>
        </button>
    </nav>

    @include('hrm.employees')
    @include('hrm.attendance')
    @include('hrm.leave')
    @include('hrm.payroll')
    @include('hrm.departments')

</main>

@include('hrm.modals.salary')
@include('hrm.modals.department')
@include('hrm.modals.employee')
@include('hrm.modals.leave')
@include('hrm.modals.bulk-import')

<x-loading id="leaveLoader" size="lg" color="brand" full-page="false" message="Processing..." :show="false" />

@include('hrm.scripts')

@endsection
