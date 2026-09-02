@extends('layouts.app')

@section('title', 'Equity')

@section('content')
<main class="ml-0 lg:ml-64 pt-20 p-6">
        
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">Equity</h1>
            <p class="text-sm text-slate-500">Equity, Dividends and Share-Premium</p>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-white border-b border-slate-200 -mx-6 px-6 mb-6">
            <div class="flex gap-8 overflow-x-auto">
                <button onclick="switchTab('equity', this)" class="tab-btn py-4 text-sm font-medium text-slate-700 border-brand-600 cursor-pointer">Equity</button>
                <button onclick="switchTab('dividends', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Dividends</button>
                <button onclick="switchTab('share-premium', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Share Premium</button>
                <button onclick="switchTab('companyShares', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Company Shares</button>

            </div>
        </div>

        <!-- Action Button Row -->
        <div class="flex flex-col gap-3 mb-4 lg:flex-row lg:items-center lg:justify-between">
            <h2 id="sectionTitle" class="text-lg font-semibold">Equity</h2>

            <div class="flex gap-6">
                <div id="sectionButton" class="w-full lg:w-auto hidden">Take it</div>

                <div id="actionButton" class="w-full lg:w-auto "></div> 
            </div>

        </div>

        <!-- Content Container -->
        <div class="bg-white border border-slate-200 rounded-lg p-4">
            <div id="tabContent" class="space-y-6">

                
                @include('equity.equity')
                @include('equity.dividends')
                @include('equity.share-premium')
                @include('equity.define-equity')

            </div>
        </div>
    </main>

    <!-- Modals -->
    @include('equity.modals.addEquity')
    @include('equity.modals.add-ShareDefinitions')
    @include('equity.modals.issue-dividends')
    @include('equity.modals.add-sharePremium')

    <!-- Shared Components -->
<!-- Scripts -->
    @include('equity.script')
@endsection
