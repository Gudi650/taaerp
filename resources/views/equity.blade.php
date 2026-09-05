@extends('layouts.app')

@section('title', 'Equity')

@section('content')
@php
    $tabChip = 'px-1.5 py-0.5 text-[11px] font-semibold text-brand-700';
    $counts = [
        'equity' => collect($equityData ?? [])->count(),
        'dividends' => collect($dividendsData ?? [])->sum(fn ($d) => $d->distributions?->count() ?? 0),
        'premium' => collect($sharePremiumsData ?? [])->count(),
        'shares' => collect($sharesDefinitions ?? [])->count(),
    ];
@endphp
<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">
    <nav class="inline-flex bg-white shadow-sm mb-6 max-w-full overflow-x-auto">
        <button type="button" onclick="switchTab('equity', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display bg-brand-600 text-white shrink-0">
            Equity <span class="{{ $tabChip }} bg-white">{{ $counts['equity'] }}</span>
        </button>
        <button type="button" onclick="switchTab('dividends', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Dividends <span class="{{ $tabChip }} bg-brand-50">{{ $counts['dividends'] }}</span>
        </button>
        <button type="button" onclick="switchTab('share-premium', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Share Premium <span class="{{ $tabChip }} bg-brand-50">{{ $counts['premium'] }}</span>
        </button>
        <button type="button" onclick="switchTab('companyShares', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Company Shares <span class="{{ $tabChip }} bg-brand-50">{{ $counts['shares'] }}</span>
        </button>
    </nav>

    <div class="flex justify-end gap-2 mb-4">
        <h2 id="sectionTitle" class="hidden">Equity</h2>
        <div id="sectionButton" class="hidden"></div>
        <div id="actionButton"></div>
    </div>

    @include('equity.equity')
    @include('equity.dividends')
    @include('equity.share-premium')
    @include('equity.define-equity')
</main>

@include('equity.modals.addEquity')
@include('equity.modals.add-ShareDefinitions')
@include('equity.modals.issue-dividends')
@include('equity.modals.add-sharePremium')
@include('equity.script')
@endsection
