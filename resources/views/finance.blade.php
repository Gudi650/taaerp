@extends('layouts.app')

@section('title', 'Finance')

@section('content')
<main class="ml-0 lg:ml-64 pt-20 p-6">
        
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">Finance</h1>
            <p class="text-sm text-slate-500">Invoices, expenses and payments</p>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-white border-b border-slate-200 -mx-6 px-6 mb-6">
            <div class="flex gap-8 overflow-x-auto">
                <button onclick="switchTab('invoices', this)" class="tab-btn py-4 text-sm font-medium text-slate-700 border-brand-600 cursor-pointer">Invoices</button>
                <button onclick="switchTab('expenses', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Expenses</button>
                {{--<button onclick="switchTab('payments', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Payments</button> --}}
                <button onclick="switchTab('accounts', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Accounts</button>
                <button onclick="switchTab('assets', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Assets</button>
                <button onclick="switchTab('liabilities', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Liabilities</button>
                <button onclick="switchTab('items', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Ledgers</button>
            </div>
        </div>

        <!-- Action Button Row -->
        <div class="flex flex-col gap-3 mb-4 lg:flex-row lg:items-center lg:justify-between">
            <h2 id="sectionTitle" class="text-lg font-semibold">Invoices</h2>

            <div class="flex gap-6">
                <div id="sectionButton" class="w-full lg:w-auto hidden">Take it</div>

                <div id="actionButton" class="w-full lg:w-auto "></div> 
            </div>

        </div>

        <!-- Content Container -->
        <div class="bg-white border border-slate-200 rounded-lg p-4">
            <div id="tabContent" class="space-y-6">
                @include('finance.invoices', ['invoices' => $invoices, 'virtualAccounts' => $virtualAccounts])
                @include('finance.expenses', ['expenses' => $expenses])
                {{-- @include('finance.payments', ['payments' => $payments]) --}}
                @include('finance.accounts', ['virtualAccounts' => $virtualAccounts])
                @include('finance.assets',['assetsCategories' => $assetsCategories, 'assetsDetails' => $assetsDetails])
                @include('finance.liabilities', ['liabilityCategories' => $liabilityCategories, 'liabilitiesDetails' => $liabilitiesDetails])
                @include('finance.items')
            </div>
        </div>
    </main>

    <!-- Modals -->
    @include('finance.modals.add-invoice')
    @include('finance.modals.add-expense')
    @include('finance.modals.add-payment')
    @include('finance.modals.add-accounts')
    @include('finance.modals.add-assets')
    @include('finance.modals.add-liabilities') 
    @include('finance.modals.add-assets-category') 
    @include('finance.modals.add-liabilities-category') 
    @include('finance.modals.add-items-category')
    @include('finance.modals.add-items')
    @include('finance.modals.issue-expenses')
    @include('finance.modals.assets-revaluation')

    <!-- Shared Components -->
<!-- Scripts -->
    @include('finance.scripts')
@endsection
