<div id="addLeaveModal" class="hidden fixed inset-0 bg-transparent z-50 flex items-start justify-center pt-20 overflow-y-auto">
    <div class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-xl mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-brand-700 font-display">Request Leave</h2>
            <button type="button" onclick="closeAddLeaveModal()" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="leaveRequestForm" class="space-y-4" method="POST" action="{{ route('leaves.store') }}" onsubmit="return submitLeaveRequest(event)">
            @csrf
            <div>
                <label class="block text-sm text-slate-600 mb-1">Employee</label>
                <div class="h-9 px-3 border border-slate-200 bg-brand-50 text-brand-700 text-sm flex items-center">{{ auth()->user()->name ?? 'Employee' }}</div>
            </div>
            <div>
                <label for="leaveType" class="block text-sm text-slate-600 mb-1">Leave type</label>
                <select id="leaveType" name="leave_type" required class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                    <option value="Annual Leave">Annual Leave</option>
                    <option value="Sick Leave">Sick Leave</option>
                    <option value="Maternity Leave">Maternity Leave</option>
                    <option value="Paternity Leave">Paternity Leave</option>
                    <option value="Compassionate Leave">Compassionate Leave</option>
                    <option value="Unpaid Leave">Unpaid Leave</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="leaveFrom" class="block text-sm text-slate-600 mb-1">From</label>
                    <input id="leaveFrom" name="from_date" type="date" required class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" />
                </div>
                <div>
                    <label for="leaveTo" class="block text-sm text-slate-600 mb-1">To</label>
                    <input id="leaveTo" name="to_date" type="date" required class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" />
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="leaveDays" class="block text-sm text-slate-600 mb-1">Days</label>
                    <input id="leaveDays" name="days" type="number" min="1" required class="w-full h-9 px-3 border border-slate-200 bg-brand-50 text-brand-700 text-sm outline-none" readonly />
                </div>
                <div>
                    <label for="leaveReason" class="block text-sm text-slate-600 mb-1">Reason</label>
                    <input id="leaveReason" name="reason" type="text" placeholder="Optional" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" />
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeAddLeaveModal()" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
                <button id="leaveSubmitBtn" type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Submit request</button>
            </div>
        </form>
    </div>
</div>
