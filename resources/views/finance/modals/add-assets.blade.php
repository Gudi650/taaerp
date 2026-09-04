<!-- Add Asset Modal -->
<div id="addAssetsModal" class="hidden">

    <!-- Form -->
    <form action="{{ route('assets.store') }}" method="POST" id="assetForm" class="space-y-4" onsubmit="showAssetCreateLoader()">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700">Asset Name</label>
            <input type="text" name="name"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Company</label>
            <select name="company_id"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="">Select Company</option>
                @if (isset($companies))
                    @foreach ($companies as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Type</label>
            <select name="type"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="">Select Type</option>
                <option>Fixed Asset</option>
                <option>Current Asset</option>
                <option>Intangible Asset</option>
                <option>Investment</option>
            </select>
        </div>

        {{-- 
        <div>
            <label class="block text-sm font-medium text-slate-700">Term</label>
            <select name="term"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="">Select Term</option>
                <option>Short-term</option>
                <option>Long-term</option>
            </select>
        </div>
         --}}

        <div class="hidden">
            <input name="term" value="Short-term" readonly />
        </div>

        <!-- Category & Sub-category -->
        <div>
            <label class="block text-sm font-medium text-slate-700">Category</label>
            <select name="category_id" id="assetCategorySelect"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <!-- Options populated from categories table -->
                <option value="">Select Category</option>
                @if (isset($assetsCategories))
                    @foreach ($assetsCategories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['category'] }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- account to take effect on --}}
        <div>
            <label class="block text-sm font-medium text-slate-700">Account</label>
            <select name="account_id" id="assetAccountSelect"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <!-- Options populated from accounts table -->
                <option value="">Select Account</option>
                @if (isset($virtualAccounts))
                    @foreach ($virtualAccounts as $account)
                        <option value="{{ $account['id'] }}">{{ $account['account_name'] }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>


        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700">Original Value</label>
                <input type="number" name="original_value"
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Current Value</label>
                <input type="number" name="current_value"
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
            </div>
        </div>

        {{-- depriciation value --}}
        <div>
            <label class="block text-sm font-medium text-slate-700">Depreciation Value(%) per Year</label>
            <input type="text" name="depreciation_value"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
        </div>


        <div>
            <label class="block text-sm font-medium text-slate-700">Acquisition Date</label>
            <input type="date" name="acquired"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Status</label>
            <select name="status"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="">Select Status</option>
                <option>Active</option>
                <option>Disposed</option>
                <option>Sold</option>
                <option>Written Off</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-3 pt-4">
            <button type="button" onclick="closeModal()"
                class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
            <button type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save Asset</button>

        </div>
    </form>

</div>

<x-loading id="AssetCreateLoader" fullPage="true" class="hidden" />

<script>
    // Show loading indicator on form submit
    document.querySelector('#addAssetModal form').addEventListener('submit', function() {
        document.getElementById('AssetCreateLoader').classList.remove('hidden');
    });

    function showAssetCreateLoader() {
        const loader = document.getElementById('AssetCreateLoader');
        if (loader) loader.classList.remove('hidden');
    }
</script>
