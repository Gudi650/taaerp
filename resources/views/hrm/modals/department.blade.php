<div id="addDepartmentModal" class="hidden fixed inset-0 bg-transparent z-50 flex items-start justify-center pt-20 overflow-y-auto">
    <div class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-lg mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-brand-700 font-display" id="departmentModalTitle">Add Department</h2>
            <button type="button" onclick="closeAddDepartmentModal()" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="departmentForm" method="POST" action="{{ route('departments.store') }}" class="space-y-4" onsubmit="return showDepartmentLoader(event)">
            @csrf
            <input type="hidden" id="departmentEditingId" value="">
            @if ($isQualifiedUser)
                <select name="company_id" id="deptCompany" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" required>
                    <option value="">Select company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @selected((string) $activeCompanyId === (string) $company->id)>{{ $company->name }}</option>
                    @endforeach
                </select>
            @else
                <input type="hidden" name="company_id" value="{{ auth()->user()?->company_id }}">
            @endif
            <input type="text" name="name" placeholder="Department name" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" id="deptName" required />
            <textarea name="description" placeholder="Description (optional)" class="w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" id="deptDesc" rows="3"></textarea>
            <div class="flex gap-3 justify-end pt-2">
                <button type="button" onclick="closeAddDepartmentModal()" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
                <button type="submit" id="departmentSubmitBtn" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save</button>
            </div>
        </form>
        <x-loading id="departmentLoader" size="lg" color="amber" full-page="true" message="Saving department details..." :show="false" />
    </div>
</div>

<x-loading id="departmentDeleteLoader" size="lg" color="amber" full-page="true" message="Deleting department..." :show="false" />
