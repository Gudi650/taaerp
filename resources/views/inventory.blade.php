@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
@php
    $tabChip = 'px-1.5 py-0.5 text-[11px] font-semibold text-brand-700';
    $counts = [
        'products' => $totalProducts ?? ($products->total() ?? collect($products ?? [])->count()),
        'suppliers' => collect($suppliers ?? [])->count(),
        'purchaseOrders' => collect($purchases ?? [])->count(),
    ];
@endphp
<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">

    <nav class="inline-flex bg-white shadow-sm mb-6 max-w-full overflow-x-auto">

        <button type="button" onclick="switchTab('products', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display bg-brand-600 text-white shrink-0">
            Products <span class="{{ $tabChip }} bg-white">{{ $counts['products'] }}</span>
        </button>

        <button type="button" onclick="switchTab('suppliers', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Suppliers <span class="{{ $tabChip }} bg-brand-50">{{ $counts['suppliers'] }}</span>
        </button>

        <button type="button" onclick="switchTab('purchaseOrders', this)" class="tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Purchase Orders <span class="{{ $tabChip }} bg-brand-50">{{ $counts['purchaseOrders'] }}</span>
        </button>
        
    </nav>

    <div class="flex justify-end gap-2 mb-4">
        <h2 id="sectionTitle" class="hidden">Products</h2>
        <div id="actionButton"></div>
    </div>

    @include('inventory.products')
    @include('inventory.suppliers')
    @include('inventory.purchase-orders')

</main>

@include('inventory.modals.add-product')
@include('inventory.modals.add-supplier')
@include('inventory.modals.add-purchase-order')
@include('inventory.scripts')
@endsection
