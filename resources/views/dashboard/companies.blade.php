<section class="lg:col-span-2 bg-white shadow-sm overflow-x-auto">
    <div class="px-5 py-4">
        <h2 class="font-display text-lg font-semibold text-brand-700">Companies</h2>
        <p class="text-xs text-slate-500 mt-0.5">Headcount and status</p>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
            <tr>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Employees</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($companies as $company)
                @php
                    $n = (int) ($company->users_count ?? 0);
                    $on = ($company->status ?? 'Active') === 'Active';
                @endphp
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-8 h-8 bg-brand-50 text-brand-700 text-xs font-semibold font-display flex items-center justify-center shrink-0">{{ strtoupper(substr($company->name, 0, 1)) }}</span>
                            <span class="font-medium text-slate-800 truncate">{{ $company->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <span class="w-16 h-1.5 bg-slate-100">
                                <span class="block h-1.5 bg-brand-600" style="width: {{ (int) round($n / $maxHeadcount * 100) }}%"></span>
                            </span>
                            <span class="tabular-nums w-6 text-right">{{ $n }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 text-[11px] font-medium {{ $on ? 'bg-brand-50 text-brand-700' : 'bg-slate-50 text-slate-500' }}">{{ $company->status ?? 'Active' }}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-5 py-10 text-center text-slate-500">No companies registered yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
