<div class="flex flex-col sm:flex-row gap-2 mb-4">
    <form method="GET" action="{{ route('companies') }}" class="flex-1 flex gap-2">
        <input id="search" name="search" type="text" value="{{ $search ?? '' }}" placeholder="Search companies"
            class="flex-1 h-9 px-3 bg-white border border-slate-200 text-sm outline-none focus:border-brand-600">
        <button type="submit" class="h-9 px-4 bg-brand-600 text-white text-sm font-medium hover:bg-brand-700">Search</button>
    </form>
    <button id="addCompanyBtn" type="button" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium shrink-0">Add company</button>
</div>

<div class="bg-white shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
            <tr>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Country</th>
                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Revenue</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($companies as $company)
                @php $on = ($company->status ?? '') === 'Active'; @endphp
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-8 h-8 bg-brand-50 text-brand-700 text-xs font-semibold font-display flex items-center justify-center shrink-0">{{ strtoupper(substr($company->name, 0, 1)) }}</span>
                            <span class="font-medium text-slate-800 truncate">{{ $company->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-slate-600">{{ $company->country }}</td>
                    <td class="px-5 py-3 text-right mono">TZS {{ number_format((float) $company->revenue, 0) }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 text-[11px] font-medium {{ $on ? 'bg-brand-50 text-brand-700' : 'bg-slate-50 text-slate-500' }}">{{ $company->status }}</span>
                    </td>
                    <td class="px-5 py-3">
                        <button type="button" title="Delete company" onclick="deleteCompany({{ $company->id }})" class="w-8 h-8 bg-red-50 text-red-600 hover:bg-red-100">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4h8v2m2 0l-1 14H7L6 6"/></svg>
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-slate-500">No companies found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
