@extends('layouts.app')

@section('title', 'Sales')

@section('content')
@php
    $tabChip = 'px-1.5 py-0.5 text-[11px] font-semibold text-brand-700';
    $counts = [
        'customers' => collect($customers ?? [])->count(),
        'orders' => collect($orders ?? [])->count(),
        'contracts' => collect($contracts ?? [])->count(),
    ];
@endphp
<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">
    <nav class="inline-flex bg-white shadow-sm mb-6 max-w-full overflow-x-auto">
        <button type="button" onclick="switchTab('customers', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display bg-brand-600 text-white shrink-0">
            Customers <span class="{{ $tabChip }} bg-white">{{ $counts['customers'] }}</span>
        </button>
        <button type="button" onclick="switchTab('orders', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Orders <span class="{{ $tabChip }} bg-brand-50">{{ $counts['orders'] }}</span>
        </button>
        <button type="button" onclick="switchTab('contracts', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Contracts <span class="{{ $tabChip }} bg-brand-50">{{ $counts['contracts'] }}</span>
        </button>
    </nav>

    <div class="flex justify-end gap-2 mb-4">
        <div id="actionButton"></div>
    </div>

    @include('sales.customers')
    @include('sales.orders')
    @include('sales.contracts')
</main>
<x-loading id="customerCreateLoader" size="lg" color="amber" full-page="true" message="Saving customer..." :show="false" />
<x-loading id="orderLoader" size="lg" color="amber" full-page="true" message="Processing order..." :show="false" />
@include('sales.modals.add-customer')
@include('sales.modals.add-order')
@include('sales.modals.edit-order')
@include('sales.modals.add-contract')
@include('sales.modals.edit-contract')
@include('sales.scripts')
@endsection
