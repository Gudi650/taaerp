<div id="createRoleModalBackdrop" class="hidden fixed inset-0 bg-transparent z-50 flex items-start justify-center pt-20 overflow-y-auto">
    <div class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-lg mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-brand-700 font-display">Create Role</h2>
            <button id="closeCreateRoleModalBtn" type="button" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="createRoleForm" method="POST" action="{{ route('roles.store') }}" class="space-y-4" onsubmit="return showLoader(event, 'createRoleLoader')">
            @csrf

            <div>
                <label for="role_template" class="block text-sm text-slate-600 mb-1">Choose role</label>
                <select id="role_template" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                    <option value="">Select a common role</option>
                    <option value="CEO">CEO</option>
                    <option value="Admin">Admin</option>
                    <option value="Accountant">Accountant</option>
                    <option value="HR Manager">HR Manager</option>
                </select>
            </div>

            <div>
                <label for="role_name" class="block text-sm text-slate-600 mb-1">Role name</label>
                <input id="role_name" name="name" type="text" required class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" placeholder="e.g. Manager" />
                <p id="role_name_help" class="text-xs text-slate-500 mt-1 hidden">Enter a custom role name.</p>
            </div>

            <div>
                <label for="role_description" class="block text-sm text-slate-600 mb-1">Description (optional)</label>
                <textarea id="role_description" name="description" rows="3" class="w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" placeholder="Short description"></textarea>
            </div>

            <div class="flex gap-3 justify-end pt-2">
                <button id="cancelCreateRoleBtn" type="button" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
                <button id="submitCreateRoleBtn" type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Create role</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function(){
        var template = document.getElementById('role_template');
        var nameInput = document.getElementById('role_name');
        var help = document.getElementById('role_name_help');
        function update(){
            if(!template) return;
            var v = template.value;
            if(!v){
                nameInput.value = '';
                nameInput.readOnly = false;
                help.classList.remove('hidden');
            } else if(v === 'other'){
                nameInput.value = '';
                nameInput.readOnly = false;
                nameInput.focus();
                help.classList.add('hidden');
            } else {
                nameInput.value = v;
                nameInput.readOnly = true;
                help.classList.add('hidden');
            }
        }
        if(template) template.addEventListener('change', update);
        if(document.readyState === 'loading'){
            document.addEventListener('DOMContentLoaded', update);
        } else {
            update();
        }
    })();
</script>

<x-loading id="createRoleLoader" message="Creating role..." :show="false" fullPage />
