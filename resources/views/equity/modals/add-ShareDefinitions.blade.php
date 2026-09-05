<!-- Add Company Shares Modal -->
<div id="addCompanySharesModal" class="hidden">
    <!-- Form -->
    <form action="{{ route('shares-definitions.store') }}" method="POST" class="space-y-4" onsubmit="showShareDefintionsCreateLoader()">
        <!-- Company -->
        <div>
            <label class="block text-sm font-medium text-slate-700">Company</label>
            <select name="company_id"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="">Select company...</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Authorized Shares -->
        <div>
            <label class="block text-sm font-medium text-slate-700">Authorized Shares</label>
            <input type="number" name="authorized_shares"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                placeholder="e.g. 100000">
        </div>

        <!-- Issued Shares -->
        <div>
            <label class="block text-sm font-medium text-slate-700">Issued Shares</label>
            <input type="number" name="issued_shares"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                placeholder="e.g. 75000">
        </div>

        <!-- Share Value -->
        <div>
            <label class="block text-sm font-medium text-slate-700">Share Value (TZS)</label>
            <input type="number" name="share_value"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                placeholder="e.g. 100">
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
            <button type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save Shares</button>
        </div>
        
    </form>

</div>

{{-- adding the loader when the user submits the datas as well here --}}
<x-loading id="AddShareDefintionsCreateLoader" fullPage="true" class="hidden" />

<script>

    // Show loading indicator on form submit
    document.querySelector('#addAccountModal form').addEventListener('submit', function () {
        document.getElementById('AddShareDefintionsCreateLoader').classList.remove('hidden');
    });

    function showShareDefintionsCreateLoader() {
        const loader = document.getElementById('AddShareDefintionsCreateLoader');
        if (loader) loader.classList.remove('hidden');
    }

</script>
