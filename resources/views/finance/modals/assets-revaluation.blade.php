<div id="addAssetRevaluationModal" class="hidden">
    <form method="POST" id="addAssetRevaluationForm" onsubmit="showRevaluationLoader()">
        @csrf

        <!-- Company -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Company</label>
            <select name="company_id" class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">

                <option value="">Select company...</option>
                @if (isset($companies))
                    @foreach ($companies as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                @endif

            </select>
        </div>

        <!-- Asset Name -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Asset Name</label>
            <input type="text" name="asset_name"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
        </div>

        <!-- Book Value -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Book Value</label>
            <input type="number" step="0.01" id="book_value" name="book_value"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
        </div>

        <!-- Revalued Amount -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Revalued Amount</label>
            <input type="number" step="0.01" id="revalued_amount" name="revalued_amount"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
        </div>

        <!-- Surplus -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Revaluation Surplus</label>
            <input type="text" id="surplus" name="surplus" readonly
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-brand-50 text-brand-700 text-sm outline-none">
        </div>

        <!-- Date -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Date of Revaluation</label>
            <input type="date" name="date_of_revaluation"
                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
        </div>

        <!-- Notes -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700">Notes</label>
            <textarea name="notes" class="mt-1 w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"></textarea>
        </div>

        <div class="flex gap-3 justify-end pt-2">
            <button type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save Revaluation</button>
        </div>
    </form>
</div>

<x-loading id="assetRevaluationLoader" fullPage="true" class="hidden" />

<script>
    // Show loader on submit
    function showRevaluationLoader() {
        const loader = document.getElementById('assetRevaluationLoader');
        if (loader) loader.classList.remove('hidden');
    }
    

    // Auto-calculate surplus
    document.addEventListener('DOMContentLoaded', function() {
        const bookInput = document.getElementById('book_value');
        const revaluedInput = document.getElementById('revalued_amount');
        const surplusInput = document.getElementById('surplus');

        function calculateSurplus() {
            const book = parseFloat(bookInput.value) || 0;
            const revalued = parseFloat(revaluedInput.value) || 0;
            const surplus = revalued - book;
            surplusInput.value = surplus.toFixed(2);
        }

        bookInput.addEventListener('input', calculateSurplus);
        revaluedInput.addEventListener('input', calculateSurplus);
    });


</script>
