<div id="tab-leave" class="tab-content hidden">
    <div class="flex justify-end mb-4">
        <button type="button" onclick="openAddLeaveModal()" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Request leave</button>
    </div>
    <div class="bg-white shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Employee</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Type</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">From</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">To</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Days</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody id="leaveTable">
                @forelse($leaves ?? [] as $leave)
                    @php
                        $st = $leave->status ?? 'Pending';
                        $pill = $st === 'Rejected' ? 'bg-red-50 text-red-600' : 'bg-brand-50 text-brand-700';
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 font-medium text-slate-800">{{ $leave->user?->name ?? 'Employee' }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $leave->leave_type }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $leave->from_date?->format('Y-m-d') ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $leave->to_date?->format('Y-m-d') ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $leave->days }}</td>
                        <td class="px-5 py-3"><span class="px-2 py-0.5 text-[11px] font-medium {{ $pill }}">{{ $st }}</span></td>
                        <td class="px-5 py-3">
                            @if ($st === 'Pending')
                                <div class="inline-flex gap-2">
                                    <form method="POST" action="{{ route('leaves.update', $leave->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Approved">
                                        <button type="submit" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" title="Approve">
                                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('leaves.update', $leave->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" class="w-8 h-8 bg-red-50 text-red-600 hover:bg-red-100" title="Reject">
                                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-slate-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-slate-500">No leave requests yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
