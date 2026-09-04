@extends('layouts.app')

@section('title', 'Finance')

@section('content')
@php
    $tabChip = 'px-1.5 py-0.5 text-[11px] font-semibold text-brand-700';
    $counts = [
        'invoices' => collect($invoices ?? [])->count(),
        'expenses' => collect($expenses ?? [])->count(),
        'accounts' => collect($virtualAccounts ?? [])->count(),
        'assets' => collect($assetsDetails ?? [])->count(),
        'liabilities' => collect($liabilitiesDetails ?? [])->count(),
        'items' => collect($items ?? [])->count(),
    ];
@endphp
<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">
    <nav class="inline-flex bg-white shadow-sm mb-6 max-w-full overflow-x-auto">
        <button type="button" onclick="switchTab('invoices', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display bg-brand-600 text-white shrink-0">
            Invoices <span class="{{ $tabChip }} bg-white">{{ $counts['invoices'] }}</span>
        </button>
        <button type="button" onclick="switchTab('expenses', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Expenses <span class="{{ $tabChip }} bg-brand-50">{{ $counts['expenses'] }}</span>
        </button>
        <button type="button" onclick="switchTab('accounts', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Accounts <span class="{{ $tabChip }} bg-brand-50">{{ $counts['accounts'] }}</span>
        </button>
        <button type="button" onclick="switchTab('assets', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Assets <span class="{{ $tabChip }} bg-brand-50">{{ $counts['assets'] }}</span>
        </button>
        <button type="button" onclick="switchTab('liabilities', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Liabilities <span class="{{ $tabChip }} bg-brand-50">{{ $counts['liabilities'] }}</span>
        </button>
        <button type="button" onclick="switchTab('items', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Ledgers <span class="{{ $tabChip }} bg-brand-50">{{ $counts['items'] }}</span>
        </button>
    </nav>

    <div class="flex justify-end gap-2 mb-4">
        <h2 id="sectionTitle" class="hidden">Invoices</h2>
        <div id="sectionButton" class="hidden"></div>
        <div id="actionButton"></div>
    </div>

    <div id="tabContent">
        @include('finance.invoices', ['invoices' => $invoices, 'virtualAccounts' => $virtualAccounts])
        @include('finance.expenses', ['expenses' => $expenses])
        @include('finance.accounts', ['virtualAccounts' => $virtualAccounts])
        @include('finance.assets',['assetsCategories' => $assetsCategories, 'assetsDetails' => $assetsDetails])
        @include('finance.liabilities', ['liabilityCategories' => $liabilityCategories, 'liabilitiesDetails' => $liabilitiesDetails])
        @include('finance.items')
    </div>
</main>

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
@include('finance.scripts')
@endsection
