<div id="addAccountModal" class="hidden">
    <!-- Form -->
    <form action="{{ route('virtualaccounts.store') }}" method="POST" class="space-y-4" onsubmit="showVirtualAccountCreateLoader()">
        @csrf
        <div>
            <label  class="block text-sm font-medium text-slate-600">Bank Name</label>
            <select
                name="bank_name"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="">Select a bank</option>
                <option value="CRDB">CRDB Bank</option>
                <option value="NMB">NMB Bank</option>
                <option value="NBC">NBC Bank</option>
                <option value="Stanbic">Stanbic Bank</option>
                <option value="Exim">Exim Bank</option>
                <option value="KCB">KCB Bank</option>
                <option value="Equity">Equity Bank</option>
                <option value="StandardChartered">Standard Chartered Bank</option>
                <option value="DTB">Diamond Trust Bank (DTB)</option>
                <option value="DTB">Cash Account</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600">Account Name</label>
            <input type="text" name="account_name"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                placeholder="e.g. Main Operating Account">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600">Account Number</label>
            <input type="text" name="account_number"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                placeholder="ACC-0009">
        </div>

        {{-- 
            <div>
                <label class="block text-sm font-medium text-slate-600">Card Number</label>
                <input type="text" name="card_number"
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                    placeholder="4111 2222 3333 4444">
            </div>
         --}}

        <div>
            <label class="block text-sm font-medium text-slate-600">Account Type</label>
            <select name="account_type"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="savings">Savings</option>
                <option value="checking">Checking</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600">Status</label>
            <select name="status"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>



        <div>
            <label class="block text-sm font-medium text-slate-600">Company</label>
            <select name="company_id"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                required>
                <option value="">Select a company</option>
                @if (isset($companies))
                    @foreach ($companies as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                @endif
            </select>
        </div>


        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-600">Currency</label>
                <select name="currency"
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                    <option>TZS</option>
                    <option>USD</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600">Initial Balance</label>
                <input type="number" name="balance"
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                    placeholder="0">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600">Description</label>
            <textarea name="description"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                rows="3" placeholder="Short description of the account"></textarea>
        </div>

        <!-- Footer -->
        <div class="flex justify-end space-x-3 mt-6">
            <button type="button" onclick="closeModal()"
                class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
            <button type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save Account</button>
        </div>

    </form>

</div>

<x-loading id="virtualAccountCreateLoader" fullPage="true" class="hidden" />

<script>

    // Show loading indicator on form submit
    document.querySelector('#addAccountModal form').addEventListener('submit', function () {
        document.getElementById('virtualAccountCreateLoader').classList.remove('hidden');
    });

    function showVirtualAccountCreateLoader() {
        const loader = document.getElementById('virtualAccountCreateLoader');
        if (loader) loader.classList.remove('hidden');
    }

</script>
