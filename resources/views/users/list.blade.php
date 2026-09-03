<div id="usersPane">
    <form method="GET" action="{{ route('users') }}" class="flex gap-2 mb-4">
        <input id="search" name="search" type="text" value="{{ $search ?? '' }}" placeholder="Search by name or email"
            class="flex-1 h-9 px-3 bg-white border border-slate-200 text-sm outline-none focus:border-brand-600">
        <button type="submit" class="h-9 px-4 bg-brand-600 text-white text-sm font-medium hover:bg-brand-700">Search</button>
    </form>

    <div class="bg-white shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">User</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Role</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-8 h-8 bg-brand-50 text-brand-700 text-xs font-semibold font-display flex items-center justify-center shrink-0">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-800 truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 text-[11px] font-medium {{ $user->role ? 'bg-brand-50 text-brand-700' : 'bg-slate-50 text-slate-500' }}">{{ $user->role?->name ?? 'No role' }}</span>
                        </td>
                        <td class="px-5 py-3">
                            @if ($user->company)
                                <button type="button" onclick="openAssignCompanyModal({{ $user->id }}, '{{ $user->name }}')" class="text-sm font-medium text-brand-700 hover:text-brand-600">{{ $user->company->name }}</button>
                            @else
                                <button type="button" onclick="openAssignCompanyModal({{ $user->id }}, '{{ $user->name }}')" class="h-8 px-3 bg-brand-600 text-white text-xs font-medium hover:bg-brand-700">Assign</button>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <button type="button" onclick="openAssignRoleModal({{ $user->id }}, '{{ $user->name }}')" class="h-8 px-3 bg-brand-600 text-white text-xs font-medium hover:bg-brand-700">Change role</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-slate-500">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
