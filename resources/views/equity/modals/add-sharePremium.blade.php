<div id="addSharePremiumModal" class="hidden">
    <form method="POST" action="{{ route('share-premiums.store') }}" onsubmit="showEquityCreateLoader()"> 
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Company</label>
            <select name="company_id" class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="">Select company...</option>
                @foreach($sharesDefinitions as $share)
                    <option value="{{ $share->company->id }}">{{ $share->company->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Nominal Value per Share</label>
            <input type="number" step="0.01" id="nominal_value" name="nominal_value"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Issue Price per Share</label>
            <input type="number" step="0.01" id="issue_price" name="issue_price"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Shares Issued</label>
            <input type="number" id="shares_issued" name="shares_issued"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Total Premium</label>
            <input type="text" id="total_premium" readonly
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-brand-50 text-brand-700 text-sm outline-none">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Notes</label>
            <textarea name="notes" class="mt-1 w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"></textarea>
        </div>

        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeModal()" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
            <button type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save Premium</button>
        </div>
    </form>
</div>

{{-- adding the loader when the user submits the datas as well here --}}
<x-loading id="sharePremiumCreateLoader" fullPage="true" class="hidden" />

<script>

    // Show loading indicator on form submit
    document.querySelector('#addSharePremiumModal form').addEventListener('submit', function() {
        document.getElementById('sharePremiumCreateLoader').classList.remove('hidden');
    });

    function showEquityCreateLoader() {
        const loader = document.getElementById('sharePremiumCreateLoader');
        if (loader) loader.classList.remove('hidden');
    }



</script>
