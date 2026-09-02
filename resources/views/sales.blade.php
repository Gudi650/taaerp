@extends('layouts.app')

@section('title', 'Sales')

@section('content')
<main class="ml-0 lg:ml-64 pt-16 lg:pt-20 px-4 lg:p-6">
        <div class="bg-white border-b border-slate-200 -mx-6 px-6 mb-6">
            <div class="flex gap-8 overflow-x-auto">
                <button onclick="switchTab('customers', this)"
                    class="tab-btn active py-4 text-sm font-medium text-slate-700 border-b-2 border-brand-600 cursor-pointer">Customers</button>
                <button onclick="switchTab('orders', this)"
                    class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Orders</button>
                <button onclick="switchTab('contracts', this)"
                    class="tab-btn py-4 text-sm font-medium text-slate-500 hover:text-slate-700 cursor-pointer">Contracts</button>
            </div>
        </div>
        <!-- Tab Content -->
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
