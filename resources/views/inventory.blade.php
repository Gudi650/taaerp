@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
<main class="ml-0 lg:ml-64 pt-20 p-6">
        

        <div class="bg-white border-b border-slate-200 -mx-6 px-6 mb-6">
            <div class="flex gap-8 overflow-x-auto">
                <button onclick="switchTab('products', this)" class="tab-btn active py-4 text-sm font-medium text-slate-800 border-b-2 border-brand-600 font-semibold cursor-pointer">Products</button>
                <button onclick="switchTab('suppliers', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Suppliers</button>
                <button onclick="switchTab('purchaseOrders', this)" class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Purchase Orders</button>
            </div>
        </div>

        <!-- Tab Content -->
        @include('inventory.products')
        @include('inventory.suppliers')
        @include('inventory.purchase-orders')

    </main>

    <!-- Modals -->
    @include('inventory.modals.add-product')
    @include('inventory.modals.add-supplier')
    @include('inventory.modals.add-purchase-order')
@include('inventory.scripts')
@endsection
