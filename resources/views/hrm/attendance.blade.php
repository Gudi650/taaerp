<div id="tab-attendance" class="tab-content hidden">
    <div class="flex justify-end mb-4">
        <input type="date" id="attendanceFilter" class="h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" />
    </div>
    <div class="bg-white shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Employee</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Date</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Check-in</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Check-out</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Hours</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody id="attendanceTable">
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3 font-medium text-slate-800">Amina Hassan</td>
                    <td class="px-5 py-3 text-slate-600">2026-04-30</td>
                    <td class="px-5 py-3 text-slate-600">08:15</td>
                    <td class="px-5 py-3 text-slate-600">17:45</td>
                    <td class="px-5 py-3 text-slate-600">9.5</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 text-[11px] font-medium bg-brand-50 text-brand-700">Present</span></td>
                </tr>
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3 font-medium text-slate-800">Joseph Kimani</td>
                    <td class="px-5 py-3 text-slate-600">2026-04-30</td>
                    <td class="px-5 py-3 text-slate-600">08:00</td>
                    <td class="px-5 py-3 text-slate-600">17:00</td>
                    <td class="px-5 py-3 text-slate-600">9</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 text-[11px] font-medium bg-brand-50 text-brand-700">Present</span></td>
                </tr>
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3 font-medium text-slate-800">Lucy Mwangi</td>
                    <td class="px-5 py-3 text-slate-600">2026-04-30</td>
                    <td class="px-5 py-3 text-slate-600">—</td>
                    <td class="px-5 py-3 text-slate-600">—</td>
                    <td class="px-5 py-3 text-slate-600">—</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 text-[11px] font-medium bg-red-50 text-red-600">Absent</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
