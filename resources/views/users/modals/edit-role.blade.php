<div id="editRoleModalBackdrop" class="hidden fixed inset-0 bg-transparent z-50 flex items-start justify-center pt-20 overflow-y-auto">
    <div class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-lg mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-brand-700 font-display">Edit Role</h2>
            <button id="closeEditRoleModalBtn" type="button" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="editRoleForm" method="POST" class="space-y-4" onsubmit="return showLoader(event, 'editRoleLoader')">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_role_name" class="block text-sm text-slate-600 mb-1">Role name</label>
                <input id="edit_role_name" name="name" type="text" required class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" placeholder="e.g. Manager" />
            </div>

            <div>
                <label for="edit_role_description" class="block text-sm text-slate-600 mb-1">Description (optional)</label>
                <textarea id="edit_role_description" name="description" rows="3" class="w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" placeholder="Short description"></textarea>
            </div>

            <div class="flex gap-3 justify-end pt-2">
                <button id="cancelEditRoleBtn" type="button" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
                <button id="submitEditRoleBtn" type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save changes</button>
            </div>
        </form>
    </div>
</div>

<x-loading id="editRoleLoader" message="Saving role changes..." :show="false" full-page="true" />
