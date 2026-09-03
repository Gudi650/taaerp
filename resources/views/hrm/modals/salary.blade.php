<div id="recordSalaryModal" class="hidden fixed inset-0 bg-transparent z-50 flex items-start justify-center pt-20 overflow-y-auto">
    <div class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-lg mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-brand-700 font-display" id="modalTitle">Record Salary</h2>
            <button type="button" onclick="closeRecordSalaryModal()" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="salaryForm" method="POST" action="{{ route('payroll.store') }}" class="space-y-4" onsubmit="return showSalaryLoader(event)">
            <input type="hidden" id="editingId" name="editing_id" value="">
            @csrf
            @php $recorded = collect($salaries ?? [])->pluck('user_id')->all(); @endphp
            <div>
                <label class="block text-sm text-slate-600 mb-1">Employee</label>
                <select name="user_id" required class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                    <option value="">Select employee</option>
                    @foreach ($employees as $emp)
                        @if(!in_array($emp['id'], $recorded))
                            <option value="{{ $emp['id'] }}">{{ $emp['name'] }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Basic salary</label>
                <input id="basicSalary" name="amount" type="number" step="0.01" min="0" required class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" />
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Deductions</label>
                <input id="deductions" name="deductions" type="number" step="0.01" min="0" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" value="0" />
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Net salary</label>
                <input id="netSalary" name="net_amount" type="number" step="0.01" min="0" required class="w-full h-9 px-3 border border-slate-200 bg-brand-50 text-brand-700 text-sm outline-none" readonly />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Currency</label>
                    <input name="currency" type="text" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" value="USD" />
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Effective date</label>
                    <input name="effective_date" type="date" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" />
                </div>
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Notes (optional)</label>
                <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"></textarea>
            </div>
            <div class="flex gap-3 justify-end pt-2">
                <button type="button" onclick="closeRecordSalaryModal()" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
                <button type="submit" id="salarySubmitBtn" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save</button>
            </div>
        </form>
        <x-loading id="salaryLoader" size="lg" color="amber" full-page="true" message="Saving salary..." :show="false" />
    </div>
</div>
