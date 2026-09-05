<!-- Add Equity Modal -->
<div id="addEquityModal" class="hidden">
    <!-- Form -->
    <form action="{{ route('equity-distributions.store') }}" method="POST" class="space-y-4" onsubmit="showEquityCreateLoader()" >
        <!-- Company -->
        <div>
            <label class="block text-sm font-medium text-slate-700">Company</label>
            <select name="company_id"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="">Select company...</option>
                @forelse ($sharesDefinitions as $share)
                    <option value="{{ $share->company->id }}">{{ $share->company->name }} </option> 
                @empty
                    <option class="text-sm text-red-500" disabled>Please add equity definitions of the companies first.</option>
                @endforelse
            </select>
        </div>

        <!-- Shareholder -->
        <div>
            <label class="block text-sm font-medium text-slate-700">Shareholder</label>
            <input type="text" name="shareholder"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                placeholder="e.g. Hamis Juma">
        </div>

        <!-- Equity Type
        <div>
            <label class="block text-sm font-medium text-slate-700">Equity Type</label>
            <select name="equity_type"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option>Common Stock</option>
                <option>Preferred Stock</option>
                <option>Capital Contribution</option>
            </select>
        </div>
        -->

        <!-- Shares & Ownership -->
        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium text-slate-700">Shares Issued</label>
                <input type="number" id="shares" name="shares"
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                    placeholder="e.g. 10000">
            </div>

             <!-- Value -->
            <div>
                <label class="block text-sm font-medium text-slate-700">Value Held (TZS)</label>
                <input type="number" id="share_value" name="share_value" readonly
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-brand-50 text-brand-700 text-sm outline-none"
                    placeholder="e.g. 2500000">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Ownership %</label>
                <input id="ownership_percentage" type="text" step="0.01" name="ownership" readonly
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-brand-50 text-brand-700 text-sm outline-none"
                    placeholder="e.g. 25">
            </div>

            {{-- virtual Account --}}
            <div>
                <label class="block text-sm font-medium text-slate-700">Bank </label>
                <select name="virtual_account_id"
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                    <option value="">Select bank...</option>
                    @forelse ($virtualAccounts as $account)
                        <option value="{{ $account->id }}">{{ $account->account_name }} - -  {{ $account->bank_name}}</option> 
                    @empty
                        <option class="text-sm text-red-500" disabled>Please add virtual accounts first.</option>
                    @endforelse
                </select>
            </div>

        </div>

        <!-- Notes -->
        <div>
            <label class="block text-sm font-medium text-slate-700">Notes</label>
            <textarea name="notes"
                class="mt-1 w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                rows="3" placeholder="Additional notes..."></textarea>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" onclick="closeModal()"
                class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
            <button type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save Equity</button>

        </div>

    </form>

</div>

{{-- adding the loader when the user submits the datas as well here --}}
<x-loading id="AddEquityCreateLoader" fullPage="true" class="hidden" />

<script>

    // Show loading indicator on form submit
    document.querySelector('#addEquityModal form').addEventListener('submit', function () {
        document.getElementById('AddEquityCreateLoader').classList.remove('hidden');
    });

    function showEquityCreateLoader() {
        const loader = document.getElementById('AddEquityCreateLoader');
        if (loader) loader.classList.remove('hidden');
    }


</script>

<script>
    // Embed sharesDefinitions as a JS object keyed by company_id
    const sharesDefinitionsMap = {
        @foreach($sharesDefinitions as $share)
            {{ $share->company->id }}: {
                issued_shares: {{ $share->issued_shares ?? 0 }},
                share_value: {{ $share->share_value ?? 0 }},
            },
        @endforeach
    };

    console.log('[Equity] sharesDefinitionsMap:', sharesDefinitionsMap);
</script>


