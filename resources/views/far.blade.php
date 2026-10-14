@extends('layouts.app')

@section('title', 'Fixed Asset Register')

@section('content')

@php
    $tabChip = 'px-1.5 py-0.5 text-[11px] font-semibold text-brand-700';
    $assetCount = collect($fixedAssets ?? [])->count();
@endphp

<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">
    <nav class="inline-flex bg-white shadow-sm mb-6 max-w-full overflow-x-auto">
        <button type="button" class="flex items-center gap-2 h-9 px-3 text-sm font-medium font-display bg-brand-600 text-white shrink-0">
            Assets <span class="{{ $tabChip }} bg-white">{{ $assetCount }}</span>
        </button>                                              
    </nav>

    {{--
    <div class="flex justify-end gap-2 mb-4">
        <button onclick="openAddAssetModal()" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Add Asset</button>
    </div>
    --}}

        <div class="bg-white shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                    <tr>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Code</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Category</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Asset Name</th>
                        <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Original Cost</th>
                        <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Net Book Value</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Acquired Date</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Depreciation Percentage</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                        <th class="px-5 py-3 text-center text-[11px] font-semibold uppercase tracking-wide">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($fixedAssets as $asset)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 mono text-xs text-slate-500">{{ $asset['code'] }}</td>
                            <td class="px-4 py-3">{{ $asset->category->category ?? '-' }}</td>
                            <td class="px-4 py-3 font-medium">{{ $asset['name'] }}</td>
                            <td class="px-4 py-3 text-right mono">TZS {{ number_format($asset['original_value'], 0) }}
                            </td>
                            <td class="px-4 py-3 text-right mono">TZS {{ number_format($asset['current_value'], 0) }}
                            </td>
                            <td class="px-4 py-3 ">{{ $asset['acquired'] }}</td>
                            <td class="px-4 py-3 ">
                                {{ $asset['depreciation_value'] ? $asset['depreciation_value'] . '%' : '-' }}
                            </td>

                            <td class="px-4 py-3">
                                @if ($asset['status'] === 'Active')
                                    <span class="px-2 py-1 text-xs bg-green-50 text-green-700">{{ $asset['status'] }}</span>
                                @elseif($asset['status'] === 'Disposed')
                                    <span class="px-2 py-1 text-xs bg-red-50 text-red-700">{{ $asset['status'] }}</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-amber-50 text-amber-700">{{ $asset['status'] }}</span>
                                @endif
                            </td>

                            <td>
                                <div class="flex items-center justify-center gap-2">

                                    {{-- 
                                    <a href=""
                                        class="text-emerald-600 hover:text-emerald-800 transition-colors"
                                        title="Download invoice PDF" aria-label="Download invoice PDF">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 3v12m0 0-4-4m4 4 4-4M4.5 20.25h15" />
                                        </svg>
                                    </a>
                                 --}}

                                    <button type="button" onclick="toggleFarDetails('{{ $asset['id'] }}')"
                                        class="inline-flex h-8 w-8 items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50"
                                        title="View details" aria-label="View details">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </button>

                                    @if ($asset['status'] === 'Active')
                                        <button type="button"
                                            onclick="openDisposeAssetModal({{ $asset['id'] }}, '{{ addslashes($asset['name']) }}', {{ (float) $asset['current_value'] }}, {{ (int) ($asset['company_id'] ?? 0) }})"
                                            class="h-8 px-3 border border-slate-200 text-red-600 hover:bg-red-50 text-xs font-medium"
                                            title="Dispose asset">
                                            Dispose
                                        </button>
                                    @endif

                                    {{-- editing buttons as well 

                                    <button type="button" class="text-blue-600 hover:text-blue-800 transition-colors"
                                        title="Edit invoice" aria-label="Edit invoice"
                                        onclick="openEditInvoiceModal({{ $asset['id'] }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487ZM16.862 4.487 19.5 7.125" />
                                        </svg>
                                    </button>
                                    
                                    --}}

                                    {{--  
                                    <form action="{{ route('invoices.destroy', $invoice['id']) }}" method="POST"
                                        onsubmit="return confirm('Delete invoice {{ $invoice['invoice_number'] }}?');"
                                        class="inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deleteInvoice({{ $invoice['id'] }})" title="Delete"  class="text-red-600 hover:text-red-700 transition-colors"
                                            title="Delete invoice" aria-label="Delete invoice">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.245-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0V4.875c0-1.035-.84-1.875-1.875-1.875h-3.75C9.09 3 8.25 3.84 8.25 4.875v.518" />
                                            </svg>
                                        </button>
                                    </form> 
                                 --}}
                                </div>
                            </td>
                        </tr>
                        <tr id="fixedassets-details-{{ $asset['id'] }}" class="hidden bg-slate-50">
                            <td colspan="9" class="px-4 py-4">
                            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">

                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Code:
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ $asset['code'] }}
                                    </p>
                                </div>

                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Category:
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ $asset->category->category ?? '-' }}
                                    </p>
                                </div>

                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Type:
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ number_format($asset['value'], 2) }}
                                        {{ $asset['currency'] }}
                                    </p>
                                </div>

                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Term:
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ $asset['term'] }}
                                    </p>
                                </div>

                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Status:
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ $asset['status'] }}
                                    </p>
                                </div>

                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Original Value: TZS
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ ucfirst($asset['original_value']) }}
                                    </p>
                                </div>

                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Depreciation value: TZS
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ ucfirst($asset['depreciation_value']) }}
                                    </p>
                                </div>

                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Net Book Value: TZS
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ $asset['current_value'] }}
                                    </p>
                                </div>

                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Accumulated Depreciation: TZS
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ $asset['current_value'] }}
                                    </p>
                                </div>

                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Acquired: 
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ $asset['acquired'] }}
                                    </p>
                                </div>
                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Created At: 
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ $asset['created_at'] }} 
                                    </p>
                                </div>
                                <div class="bg-brand-50 p-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Updated At: 
                                    </p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ $asset['updated_at'] ?? 'N/A' }}
                                    </p>
                                </div>

                            </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-slate-500">No assets found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        {{-- here we will put the summary as well 
        <!-- Summary -->
        <div class="mt-8 p-6 bg-white border rounded shadow-sm">
            <h3 class="text-md font-semibold mb-2">Summary</h3>
            <ul class="text-sm space-y-1">
                <li>Total Original Cost: <span class="mono">TZS 590,000,000</span></li>
                <li>Total Current Value: <span class="mono">TZS 535,000,000</span></li>
                <li class="font-bold">Net Book Value: <span class="mono">TZS 535,000,000</span></li>
            </ul>
        </div>

         --}}

    </main>
<div id="disposeAssetModal" class="hidden">
        <form id="disposeAssetForm" method="POST" class="space-y-4">
            @csrf
            <p class="text-sm text-slate-600">Asset: <span id="disposeAssetName" class="font-semibold text-brand-700"></span></p>
            <p class="text-sm text-slate-600">Net book value: <span id="disposeAssetNbv" class="font-semibold mono text-brand-700"></span></p>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Disposal date</label>
                <input type="date" name="disposal_date" id="disposal_date" required
                    class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" value="{{ now()->toDateString() }}">
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Method</label>
                <select name="disposal_method" id="disposal_method" required
                    class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                    <option value="Sold">Sold</option>
                    <option value="Disposed">Disposed / Scrapped</option>
                    <option value="Written Off">Written Off</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Proceeds (TZS)</label>
                <input type="number" step="0.01" min="0" name="disposal_proceeds" id="disposal_proceeds" value="0"
                    class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Bank account (required if proceeds &gt; 0)</label>
                <select name="disposal_bank_id" id="disposal_bank_id"
                    class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                    <option value="">— None —</option>
                    @foreach (($banks ?? []) as $bank)
                        <option value="{{ $bank->id }}" data-company="{{ $bank->company_id }}">
                            {{ $bank->account_name }} (TZS {{ number_format((float) $bank->balance, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Notes</label>
                <textarea name="disposal_notes" rows="2" class="w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal()" class="h-9 px-4 border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</button>
                <button type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Confirm disposal</button>
            </div>
        </form>
    </div>

    <script>
        function toggleFarDetails(id) {
            const detailsRow = document.getElementById(`fixedassets-details-${id}`);
            if (detailsRow) detailsRow.classList.toggle('hidden');
        }

        function openDisposeAssetModal(assetId, assetName, nbv, companyId) {
            const template = document.getElementById('disposeAssetModal');
            const clone = template.cloneNode(true);
            const form = clone.querySelector('#disposeAssetForm');
            form.action = `/far/assets/${assetId}/dispose`;
            clone.querySelector('#disposeAssetName').textContent = assetName;
            clone.querySelector('#disposeAssetNbv').textContent = 'TZS ' + Number(nbv || 0).toLocaleString();

            const bankSelect = clone.querySelector('#disposal_bank_id');
            Array.from(bankSelect.options).forEach(opt => {
                if (!opt.value) return;
                const sameCompany = !companyId || String(opt.dataset.company) === String(companyId);
                opt.hidden = !sameCompany;
                opt.disabled = !sameCompany;
            });

            window.openModal('Dispose Asset', clone.innerHTML, null, {
                widthClass: 'max-w-lg',
                hideFooter: true
            });
        }
    </script>
@endsection
