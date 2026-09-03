<div id="tab-payroll" class="tab-content hidden">
    <div class="flex flex-col sm:flex-row gap-2 mb-4 justify-end">
        <button type="button" onclick="openRecordSalaryModal()" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Record salary</button>
        <select id="payrollMonth" class="h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04" selected>April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        <select id="payrollYear" class="h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026" selected>2026</option>
        </select>
    </div>
    <div class="bg-white shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Employee</th>
                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Basic</th>
                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Deductions</th>
                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Net pay</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Action</th>
                </tr>
            </thead>
            <tbody id="payrollTable">
                @forelse($salaries ?? [] as $s)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 font-medium text-slate-800">{{ $s['employee'] }}</td>
                        <td class="px-5 py-3 text-right mono">{{ number_format($s['basic'], 0) }}</td>
                        <td class="px-5 py-3 text-right mono">{{ number_format($s['deductions'], 0) }}</td>
                        <td class="px-5 py-3 text-right mono">{{ number_format($s['net'], 0) }}</td>
                        <td class="px-5 py-3"><span class="px-2 py-0.5 text-[11px] font-medium bg-brand-50 text-brand-700">{{ $s['status'] }}</span></td>
                        <td class="px-5 py-3">
                            <div class="inline-flex gap-2">
                                <button type="button" onclick="editSalary({{ $s['id'] }}, {{ json_encode($s) }})" title="Edit" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.9 4.5l2.6 2.6M5 19l4.5-1L19 8.5a1.5 1.5 0 000-2.1L17.6 5a1.5 1.5 0 00-2.1 0L6 14.5 5 19z"/></svg>
                                </button>
                                <button type="button" onclick="deleteSalary({{ $s['id'] }})" title="Delete" class="w-8 h-8 bg-red-50 text-red-600 hover:bg-red-100">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4h8v2m2 0l-1 14H7L6 6"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-500">No salary records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
