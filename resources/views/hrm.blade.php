@extends('layouts.app')

@section('title', 'HRM')

@section('content')
<main class="ml-0 lg:ml-64 pt-20 p-6">
        <div class="bg-white border-b border-slate-200 -mx-6 px-6 mb-6">
            <div class="flex gap-8 overflow-x-auto">
                <button onclick="switchTab('employees', this)" class="tab-btn active py-4 text-sm font-medium text-slate-700 border-b-2 border-brand-600 cursor-pointer">Employees</button>
                <button onclick="switchTab('attendance', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Attendance</button>
                <button onclick="switchTab('leave', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Leave</button>
                <button onclick="switchTab('payroll', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Payroll</button>
                <button onclick="switchTab('departments', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Departments</button>
            </div>
        </div>

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
