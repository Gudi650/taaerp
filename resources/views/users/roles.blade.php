<div id="rolesPane" class="hidden">
    <div class="flex items-center justify-between gap-3 mb-4">
        <div>
            <h2 class="font-display text-lg font-semibold text-brand-700">Roles</h2>
            <p class="text-xs text-slate-500 mt-0.5">Assigned to users across companies</p>
        </div>
        <button id="openCreateRoleBtnPane" type="button" class="h-9 px-4 bg-brand-600 text-white text-sm font-medium hover:bg-brand-700">Create role</button>
    </div>

    <div class="bg-white shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Role</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Description</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 bg-brand-50 text-brand-700 text-xs font-semibold font-display flex items-center justify-center shrink-0">{{ strtoupper(substr($role->name, 0, 1)) }}</span>
                                <span class="font-medium text-slate-800">{{ $role->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $role->description ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <div class="inline-flex items-center gap-2">
                                <button type="button" onclick="openEditRoleModal({{ $role->id }}, @js($role->name), @js($role->description ?? ''))" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Edit role" title="Edit">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.9 4.5l2.6 2.6M5 19l4.5-1L19 8.5a1.5 1.5 0 000-2.1L17.6 5a1.5 1.5 0 00-2.1 0L6 14.5 5 19z"/></svg>
                                </button>
                                <form id="delete-role-form-{{ $role->id }}" method="POST" action="{{ route('roles.destroy', $role) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="openConfirm({ title: 'Delete Role', message: @js("Are you sure you want to delete {$role->name}?"), confirmText: 'Delete', cancelText: 'Cancel', variant: 'warning', onConfirm: () => { document.getElementById('deleteRoleLoader').classList.remove('hidden'); setTimeout(() => document.getElementById('delete-role-form-{{ $role->id }}').submit(), 75); } })" class="w-8 h-8 bg-red-50 text-red-600 hover:bg-red-100" aria-label="Delete role" title="Delete">
                                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4h8v2m2 0l-1 14H7L6 6"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-5 py-10 text-center text-slate-500">No roles found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-loading id="deleteRoleLoader" class="hidden" full-page="true" />
</div>
