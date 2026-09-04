<!-- Liability Category Modal -->
<div id="issueExpensesModal" class="hidden ">


    <form action="#" method="POST" id="issueExpensesForm" class="space-y-4" onsubmit="showissueExpensesCreateLoader()">

        @csrf

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Bank </label>
            <select id="expenseBank" name="bank_id" required
                class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="">Select bank...</option>

                @foreach ($virtualAccounts as $account)
                    <option value="{{ $account['id'] }}" @selected(isset($currentBankId) && (string) $currentBankId === (string) $account['id'])>
                        {{ $account['account_name'] }}
                    </option>
                @endforeach

            </select>
        </div>

        <!--add payment method select-->
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Payment Method </label>
            <select id="expensePaymentMethod" name="payment_method" required
                class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="">Select payment method...</option>

                <option value="">Select payment method...</option>
                <!--<option value="Cash">Cash</option> -->
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Mobile Money">Mobile Money</option>
                <option value="Cheque">Cheque</option>

            </select>
        </div>

        <!--add reference input-->
        <div>
            <label class="block text-sm font-medium text-slate-700">Reference</label>
            <input type="text" name="reference" class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                placeholder="Enter reference">
        </div>
        

        <div>
            <label class="block text-sm font-medium text-slate-700">Description</label>
            <textarea name="description" class="mt-1 w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" rows="3"
                placeholder="Enter description"></textarea>
        </div>


        <div class="flex justify-end gap-3 pt-4">
            <button type="button" onclick="closeModal()"
                class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
            <button type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save</button>
        </div>
    </form>

</div>

<x-loading id="liabilityCategoryCreateLoader" fullPage="true" class="hidden" />

<script>
    function showissueExpensesCreateLoader() {
        const loader = document.getElementById('issueExpensesCreateLoader');
        if (loader) {
            loader.classList.remove('hidden');
        }
    }
</script>
