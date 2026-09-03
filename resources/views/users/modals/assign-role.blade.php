<div id="assignRoleModalBackdrop" class="hidden fixed inset-0 bg-transparent z-50 flex items-start justify-center pt-20 overflow-y-auto">
    <div class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-lg mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-brand-700 font-display">Assign Role</h2>
            <button id="closeAssignRoleModalBtn" type="button" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="assignRoleForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="selected_user_name" class="block text-sm text-slate-600 mb-1">User</label>
                <input id="selected_user_name" type="text" class="w-full h-9 px-3 border border-slate-200 bg-brand-50 text-brand-700 text-sm outline-none" readonly />
            </div>

            <div>
                <label for="role_id" class="block text-sm text-slate-600 mb-1">Select new role</label>
                <select id="role_id" name="role_id" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" required>
                    <option value="">Choose a role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }} - {{ $role->description }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3 justify-end pt-2">
                <button id="cancelAssignRoleBtn" type="button" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
                <button id="submitAssignRoleBtn" type="button" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Assign role</button>
            </div>
        </form>
    </div>
</div>
