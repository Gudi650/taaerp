@php
    $totalProducts = $totalProducts ?? $products->total();
    $totalStockValue = $totalStockValue ?? $products->getCollection()->sum(fn ($product) => (float) $product->stock * (float) $product->selling_price);
    $lowStockCount = $lowStockCount ?? $products->getCollection()->filter(fn ($product) => (int) $product->stock <= (int) $product->reorder_level)->count();
    $expiringSoonCount = $expiringSoonCount ?? $products->getCollection()->filter(function ($product) {
        if (empty($product->expiry_date)) {
            return false;
        }

        $expiryDate = \Carbon\Carbon::parse($product->expiry_date);

        return $expiryDate->between(now(), now()->addDays(30));
    })->count();
@endphp

<div id="productsPane" class="tab-content">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500 mb-1">Total Products</p>
            <p class="text-2xl font-semibold text-brand-700">{{ number_format($totalProducts) }}</p>
        </div>
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500 mb-1">Total Stock Value</p>
            <p class="text-2xl font-semibold text-brand-700">TZS {{ number_format($totalStockValue, 2) }}</p>
        </div>
        <div class="bg-white shadow-sm border-l-4 border-l-amber-500 p-4">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500 mb-1">Low Stock Items</p>
            <p class="text-2xl font-semibold text-brand-700">{{ number_format($lowStockCount) }}</p>
        </div>
        <div class="bg-white shadow-sm border-l-4 border-l-red-500 p-4">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500 mb-1">Expiring Soon</p>
            <p class="text-2xl font-semibold text-brand-700">{{ number_format($expiringSoonCount) }}</p>
        </div>
    </div>

    <div class="bg-white shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                    <tr>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Inventory ID</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Product Name</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">SKU</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                        <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Quantity in Stock</th>
                        <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Total Value</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                        <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        @php
                            $inventoryId = 'INV-' . str_pad((string) $product->id, 4, '0', STR_PAD_LEFT);
                            $stockValue = (float) $product->stock * (float) $product->selling_price;
                            $isLowStock = (int) $product->stock <= (int) $product->reorder_level;
                            $expiryDate = $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date) : null;
                            $isExpiringSoon = $expiryDate ? $expiryDate->between(now(), now()->addDays(30)) : false;

                            $stockBadgeClass = $isLowStock
                                ? 'bg-amber-100 text-amber-700'
                                : 'bg-green-100 text-green-700';

                            $status = $product->status ?: 'Active';
                            $statusClass = match ($status) {
                                'Inactive' => 'bg-slate-100 text-slate-700',
                                'Discontinued' => 'bg-red-50 text-red-700',
                                'Out of Stock' => 'bg-amber-50 text-amber-700',
                                default => 'bg-green-50 text-green-700',
                            };
                        @endphp
                        <tr data-product-id="{{ $product->id }}"
                            data-product-name="{{ e($product->name) }}"
                            data-product-sku="{{ e($product->sku) }}"
                            data-product-barcode="{{ e($product->barcode) }}"
                            data-product-category="{{ e($product->category) }}"
                            data-product-brand="{{ e($product->brand) }}"
                            data-product-company-id="{{ $product->company_id }}"
                            data-product-status="{{ e($product->status) }}"
                            data-product-stock="{{ (int) $product->stock }}"
                            data-product-unit="{{ e($product->unit_of_measure) }}"
                            data-product-reorder="{{ (int) $product->reorder_level }}"
                            data-product-location="{{ e($product->location) }}"
                            data-product-last-restocked="{{ $product->last_restocked_date }}"
                            data-product-last-movement="{{ e($product->last_stock_movement) }}"
                            data-product-cost="{{ (float) $product->cost_per_unit }}"
                            data-product-selling="{{ (float) $product->selling_price }}"
                            data-product-profit="{{ $product->profit_margin }}"
                            data-product-tax="{{ e($product->tax_vat) }}"
                            data-product-supplier="{{ e($product->supplier_id) }}"
                            data-product-expiry="{{ $product->expiry_date }}"
                            data-product-description="{{ e($product->product_description) }}"
                        >
                            <td class="px-4 py-3 text-sm">{{ $inventoryId }}</td>
                            <td class="px-4 py-3 text-sm">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-sm font-mono text-xs">{{ $product->sku }}</td>
                            <td class="px-4 py-3 text-sm">{{ $product->company?->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-right">
                                {{ number_format((float) $product->stock) }}
                                <span class="ml-2 inline-flex items-center px-1.5 py-0.5 text-xs font-medium {{ $stockBadgeClass }}">{{ $isLowStock ? 'Low Stock' : 'Sufficient' }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-right">{{ number_format($stockValue, 2) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 text-xs {{ $statusClass }}">{{ $status }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex justify-end items-center gap-2 whitespace-nowrap">
                                    <button type="button" title="View" onclick="toggleProductDetails('{{ $product->id }}')" class="inline-flex h-8 w-8 items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </button>
                                    <button type="button" title="Edit" onclick="openEditProduct({{ $product->id }})" class="inline-flex h-8 w-8 items-center justify-center border border-slate-200 text-brand-700 hover:bg-brand-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487ZM16.862 4.487 19.5 7.125" />
                                        </svg>
                                    </button>
                                    <button type="button" title="Delete" onclick="confirmDeleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')" class="inline-flex h-8 w-8 items-center justify-center border border-slate-200 text-red-600 hover:bg-red-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.245-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0V4.875c0-1.035-.84-1.875-1.875-1.875h-3.75C9.09 3 8.25 3.84 8.25 4.875v.518" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr id="details-{{ $product->id }}" class="hidden bg-slate-50">
                            <td colspan="8" class="px-4 py-3">
                                <div class="bg-white p-4 shadow-sm">
                                    <div class="mb-4 flex items-start justify-between">
                                        <div>
                                            <div class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-500">Product Details</div>
                                            <p class="text-sm italic text-slate-600 mb-4">{{ $product->product_description ?? 'No product description provided.' }}</p>
                                        </div>
                                        <div class="flex-shrink-0 w-16 h-16 bg-brand-50 border border-slate-200 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-slate-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.5v2.25m0-4.5v2.25m9-9L3.75 7.5" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-3 text-sm md:grid-cols-3">
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Category:</span> <span class="block font-medium text-slate-800">{{ $product->category ?? 'N/A' }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Brand / Manufacturer:</span> <span class="block font-medium text-slate-800">{{ $product->brand ?? 'N/A' }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Unit of Measure:</span> <span class="block font-medium text-slate-800">{{ $product->unit_of_measure ?? 'N/A' }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Cost per Unit:</span> <span class="block font-medium text-slate-800">{{ number_format((float) $product->cost_per_unit, 2) }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Unit Selling Price:</span> <span class="block font-medium text-slate-800">{{ number_format((float) $product->selling_price, 2) }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Profit Margin %:</span> <span class="block font-medium text-green-700">{{ $product->profit_margin !== null ? number_format((float) $product->profit_margin, 2) . '%' : 'N/A' }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Barcode:</span> <span class="block font-medium text-slate-800 font-mono text-xs">{{ $product->barcode ?? 'N/A' }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Expiry Date:</span>
                                            <span class="block font-medium {{ $expiryDate && $expiryDate->isPast() ? 'text-red-700' : ($isExpiringSoon ? 'text-amber-700' : 'text-slate-800') }}">
                                                {{ $expiryDate ? $expiryDate->format('d M Y') : 'No Expiry' }}
                                            </span>
                                            @if ($expiryDate && $expiryDate->isPast())
                                                <span class="text-xs text-red-600 mt-1 block">Expired</span>
                                            @elseif ($isExpiringSoon)
                                                <span class="text-xs text-amber-600 mt-1 block">⚠️ Expiring Soon</span>
                                            @endif
                                        </div>
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Tax / VAT:</span> <span class="block font-medium text-slate-800">{{ $product->tax_vat ?? 'N/A' }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Location:</span> <span class="block font-medium text-slate-800">{{ $product->location ?? 'N/A' }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Reorder Level:</span> <span class="block font-medium text-slate-800">{{ number_format((int) $product->reorder_level) }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2"><span class="text-xs text-slate-500">Supplier:</span> <span class="block font-medium text-slate-800">{{ $product->supplier_id ?? 'N/A' }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2 md:col-span-2"><span class="text-xs text-slate-500">Last Restocked Date:</span> <span class="block font-medium text-slate-800">{{ $product->last_restocked_date ? \Carbon\Carbon::parse($product->last_restocked_date)->format('d M Y') : 'N/A' }}</span></div>
                                        <div class="bg-brand-50 px-3 py-2 md:col-span-3"><span class="text-xs text-slate-500">Last Stock Movement:</span> <span class="block font-medium text-slate-800">{{ $product->last_stock_movement ?? 'N/A' }}</span></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
                                <div class="mx-auto max-w-sm">
                                    <div class="mx-auto mb-3 w-14 h-14 bg-brand-50 flex items-center justify-center text-brand-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.5v2.25m0-4.5v2.25m9-9L3.75 7.5" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-semibold text-slate-800">No products yet</h3>
                                    <p class="mt-1 text-sm text-slate-500">Add your first product to start managing inventory here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        @if ($products->hasPages())
            <div class="px-4 py-4 border-t border-slate-200">
                {{ $products->links() }}
            </div>
        @endif
    </div>
    
    <!-- Hidden delete form used by confirm dialog -->
    <form id="productDeleteForm" method="POST" style="display:none">
        @csrf
        @method('DELETE')
    </form>

    @include('components.loading', [
        'id' => 'productDeleteLoading',
        'show' => false,
        'fullPage' => true,
    ])
</div>
