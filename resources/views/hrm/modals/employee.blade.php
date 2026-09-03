<x-loading id="employeeDeleteLoader" size="lg" color="amber" full-page="true" message="Deleting employee..." :show="false" />

<div id="addEmployeeModal" class="hidden fixed inset-0 bg-transparent z-50 flex items-start justify-center pt-20 overflow-y-auto">
    <div class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-lg mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-brand-700 font-display">Add Employee</h2>
            <button type="button" onclick="closeAddEmployeeModal()" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="employeeForm" method="POST" action="{{ route('employees.store') }}" class="space-y-4" onsubmit="return showEmployeeLoader(event)">
            @csrf
            <input type="text" name="name" placeholder="Full name" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" id="empName" required />
            <input type="email" name="email" placeholder="Email" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" id="empEmail" required />
            <input type="tel" name="phone_number" placeholder="Phone" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" id="empPhone" />

            @if ($isQualifiedUser)
                <select name="company_id" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" id="empCompany" required>
                    <option value="">Select company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @selected((string) $activeCompanyId === (string) $company->id)>{{ $company->name }}</option>
                    @endforeach
                </select>
            @else
                <input type="hidden" name="company_id" value="{{ auth()->user()?->company_id }}">
                <div class="w-full h-9 px-3 border border-slate-200 bg-brand-50 text-brand-700 text-sm flex items-center">{{ auth()->user()?->company?->name ?? 'No company assigned' }}</div>
            @endif

            <select name="department_id" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" id="empDept">
                <option value="">Select department</option>
            </select>
            <input type="date" name="join_date" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" id="empJoinDate" />

            <div class="flex gap-3 justify-end pt-2">
                <button type="button" onclick="closeAddEmployeeModal()" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
                <button type="submit" id="employeeSubmitBtn" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save</button>
            </div>
        </form>
        <x-loading id="employeeLoader" size="lg" color="amber" full-page="true" message="Saving employee details..." :show="false" />
    </div>
</div>
