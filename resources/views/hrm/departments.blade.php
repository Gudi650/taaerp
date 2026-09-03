<div id="tab-departments" class="tab-content hidden">
    <div class="flex justify-end mb-4">
        <button type="button" onclick="openAddDepartmentModal()" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Add department</button>
    </div>
    <div class="bg-white shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Name</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Description</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Created</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Action</th>
                </tr>
            </thead>
            <tbody id="departmentsTable">
                @forelse($departments as $department)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-8 h-8 bg-brand-50 text-brand-700 text-xs font-semibold font-display flex items-center justify-center shrink-0">{{ strtoupper(substr($department['name'], 0, 1)) }}</span>
                                <span class="font-medium text-slate-800 truncate">{{ $department['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $department['description'] }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $department['company_name'] }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $department['created_at'] }}</td>
                        <td class="px-5 py-3">
                            <div class="inline-flex gap-2">
                                <button type="button" onclick='editDepartment({{ json_encode($department) }})' title="Edit" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.9 4.5l2.6 2.6M5 19l4.5-1L19 8.5a1.5 1.5 0 000-2.1L17.6 5a1.5 1.5 0 00-2.1 0L6 14.5 5 19z"/></svg>
                                </button>
                                <button type="button" onclick="deleteDepartment({{ $department['id'] }})" title="Delete" class="w-8 h-8 bg-red-50 text-red-600 hover:bg-red-100">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4h8v2m2 0l-1 14H7L6 6"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-slate-500">No departments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
