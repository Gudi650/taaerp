<div id="addCompanyModalBackdrop" class="hidden fixed inset-0 bg-transparent z-50 flex items-start justify-center pt-20 overflow-y-auto">
    <div class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-lg mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-brand-700 font-display">Add Company</h2>
            <button id="closeAddCompanyModalBtn" type="button" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="companyForm" method="POST" action="{{ route('companies.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="company_name" class="block text-sm text-slate-600 mb-1">Company name</label>
                <input id="company_name" name="name" value="{{ old('name') }}" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" required />
            </div>

            <div>
                <label for="company_country" class="block text-sm text-slate-600 mb-1">Country</label>
                <input id="company_country" name="country" value="{{ old('country') }}" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" required />
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="company_revenue" class="block text-sm text-slate-600 mb-1">Revenue (TZS)</label>
                    <input id="company_revenue" name="revenue" type="number" min="0" step="0.01" value="{{ old('revenue', 0) }}" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" required />
                </div>
                <div>
                    <label for="company_status" class="block text-sm text-slate-600 mb-1">Status</label>
                    <select id="company_status" name="status" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" required>
                        <option value="Active" {{ old('status') === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3 justify-end pt-2">
                <button id="cancelAddCompanyBtn" type="button" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
                <button id="submitCompanyBtn" type="button" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Submit</button>
            </div>
        </form>
    </div>
</div>
