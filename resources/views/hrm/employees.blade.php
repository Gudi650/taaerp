<div id="tab-employees" class="tab-content">
    <div class="flex flex-col sm:flex-row gap-2 mb-4 justify-end">
        <button type="button" onclick="openAddEmployeeModal()" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Add employee</button>
        <button type="button" onclick="openBulkImportModal()" class="h-9 px-4 bg-brand-50 text-brand-700 text-sm font-medium hover:bg-brand-100">Import CSV</button>
    </div>
    <div class="bg-white shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Name</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Department</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Position</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Join date</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Action</th>
                </tr>
            </thead>
            <tbody id="employeesTable">
                @forelse($employees as $employee)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-8 h-8 bg-brand-50 text-brand-700 text-xs font-semibold font-display flex items-center justify-center shrink-0">{{ strtoupper(substr($employee['name'], 0, 1)) }}</span>
                                <span class="font-medium text-slate-800 truncate">{{ $employee['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $employee['department'] }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $employee['position'] }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $employee['company_name'] }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $employee['join_date'] }}</td>
                        <td class="px-5 py-3"><span class="px-2 py-0.5 text-[11px] font-medium bg-brand-50 text-brand-700">{{ $employee['status'] }}</span></td>
                        <td class="px-5 py-3">
                            <button type="button" onclick="deleteEmployee({{ $employee['id'] }})" title="Delete" class="w-8 h-8 bg-red-50 text-red-600 hover:bg-red-100">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4h8v2m2 0l-1 14H7L6 6"/></svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-slate-500">No employees found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
