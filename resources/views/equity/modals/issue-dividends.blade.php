<!-- Issue Dividend Modal -->
<div id="issueDividendModal" class="hidden fixed inset-0 z-50 items-start justify-center pt-20 pb-10 overflow-y-auto bg-transparent">
    <div class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-lg mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-brand-700 font-display">Issue Dividend</h2>
            <button type="button" onclick="closeDividendModal()" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Form -->
        <form action={{ route('dividends.store') }} method="POST" class="space-y-4" onsubmit="showDividendCreateLoader()">
            @csrf

            <!-- Company -->
            <div>
                <label class="block text-sm font-medium text-slate-700">Company</label>
                <select name="company_id"
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                    <option value="">Select company...</option>

                    @forelse ($sharesDefinitions as $share)
                        <option value="{{ $share->company->id }}">{{ $share->company->name }}</option>
                    @empty
                        <option class="text-sm text-red-500" disabled>Please add equity definitions of the companies first.</option>
                    @endforelse

                </select>
            </div>

            <!-- Dividend Amount -->
            <div>
                <label class="block text-sm font-medium text-slate-700">Total Dividend Amount (TZS)</label>
                <input type="number" name="amount"
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                    placeholder="e.g. 20000000">
            </div>

            <!-- Declared Date -->
            <div>
                <label class="block text-sm font-medium text-slate-700">Declared Date</label>
                <input type="date" name="declared_at"
                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
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
                <button type="button" onclick="closeDividendModal()"
                    class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
                <button type="submit"
                    class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Distribute Dividend</button>
            </div>
        </form>
    </div>
</div>

{{-- adding the loader when the user submits the datas as well here --}}
<x-loading id="IssueDividendCreateLoader" fullPage="true" class="hidden" />

<script>
    function openDividendModal() {
        document.getElementById('issueDividendModal').classList.remove('hidden');
        document.getElementById('issueDividendModal').classList.add('flex');
    }

    function closeDividendModal() {
        document.getElementById('issueDividendModal').classList.add('hidden');
        document.getElementById('issueDividendModal').classList.remove('flex');
    }

    // Show loading indicator on form submit
    document.querySelector('#issueDividendModal form').addEventListener('submit', function() {
        document.getElementById('IssueDividendCreateLoader').classList.remove('hidden');
    });

    function showDividendCreateLoader() {
        const loader = document.getElementById('IssueDividendCreateLoader');
        if (loader) loader.classList.remove('hidden');
    }
</script>
