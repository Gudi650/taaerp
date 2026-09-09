{{-- dd the datas --}}
{{-- @dd($loans); --}}
{{-- dd the companies --}}
{{-- @dd($companies); --}}
{{-- dd the approvers --}}
{{-- @dd($approvers); --}}
{{-- dd the virtual accounts --}}
{{-- @dd($virtualAccounts); --}}

@extends('layouts.app')

@section('title', 'Loans')

@section('content')
@php
    $tabChip = 'px-1.5 py-0.5 text-[11px] font-semibold text-brand-700';
    $counts = [
        'register' => collect($loans ?? [])->count(),
        'schedule' => collect($loans ?? [])->count(),
        'repayments' => collect($repayments ?? [])->count(),
        'summary' => collect($interestSummary ?? [])->count(),
    ];
@endphp
<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">
    <nav class="inline-flex bg-white shadow-sm mb-6 max-w-full overflow-x-auto">
        <button type="button" onclick="switchLoanTab('register', this)" class="loan-tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display bg-brand-600 text-white shrink-0">
            Register <span class="{{ $tabChip }} bg-white">{{ $counts['register'] }}</span>
        </button>
        <button type="button" onclick="switchLoanTab('schedule', this)" class="loan-tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Schedule <span class="{{ $tabChip }} bg-brand-50">{{ $counts['schedule'] }}</span>
        </button>
        <button type="button" onclick="switchLoanTab('repayments', this)" class="loan-tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Repayments <span class="{{ $tabChip }} bg-brand-50">{{ $counts['repayments'] }}</span>
        </button>
        <button type="button" onclick="switchLoanTab('summary', this)" class="loan-tab-btn flex items-center gap-2 h-9 px-3 text-sm font-medium font-display text-brand-700 shrink-0">
            Interest <span class="{{ $tabChip }} bg-brand-50">{{ $counts['summary'] }}</span>
        </button>
    </nav>

    <div class="flex justify-end gap-2 mb-4">
        <h2 id="loanSectionTitle" class="hidden">Loan Register</h2>
        <select id="loanCompanyFilter" onchange="filterLoansByCompany(this.value)"
            class="h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
            <option value="all">All Companies</option>
            @foreach ($companies ?? [] as $company)
                <option value="{{ $company->name }}">{{ $company->name }}</option>
            @endforeach
        </select>
        <div id="loanActionButton"></div>
    </div>

    <div id="loanTabContent">

                {{-- ============================= LOAN REGISTER ============================= --}}
                <div id="loan-tab-register" class="loan-tab-panel">
                    <div class="bg-white shadow-sm overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                                <tr>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Loan Code</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Type</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Lender / Counterparty</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Principal</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Interest Rate</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Term</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Outstanding</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                                    <th class="px-5 py-3 text-center text-[11px] font-semibold uppercase tracking-wide">Disbursement</th>
                                    <th class="px-5 py-3 text-center text-[11px] font-semibold uppercase tracking-wide">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($loans ?? [] as $loan)
                                    <tr class="hover:bg-slate-50 loan-row" data-company="{{ $loan->company?->name ?? '-' }}">
                                        <td class="px-4 py-3 mono text-xs text-slate-500">{{ $loan->code }}</td>
                                        <td class="px-4 py-3 text-xs">
                                            @php
                                                $typeLabel = match ($loan->loan_type ?? 'external_borrow') {
                                                    'intercompany' => 'Inter-company',
                                                    'employee' => 'Employee',
                                                    default => 'External',
                                                };
                                            @endphp
                                            <span class="inline-flex px-2 py-0.5 text-xs bg-slate-100 text-slate-700 border border-slate-200">{{ $typeLabel }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex px-2 py-0.5 text-xs bg-brand-50 text-brand-700 border border-brand-100">{{ $loan->company?->name ?? '-' }}</span>
                                        </td>
                                        <td class="px-4 py-3 font-medium">
                                            @if (($loan->loan_type ?? '') === 'intercompany')
                                                {{ $loan->counterpartyCompany?->name ?? $loan->lender }}
                                            @elseif (($loan->loan_type ?? '') === 'employee')
                                                {{ $loan->employee?->name ?? $loan->lender }}
                                            @else
                                                {{ $loan->lender }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-right mono">TZS {{ number_format((float) ($loan->principal ?? 0)) }}</td>
                                        <td class="px-4 py-3 text-right mono">{{ $loan->interest_rate }}% <span class="text-xs text-slate-400">({{ $loan->interest_type }})</span></td>
                                        <td class="px-4 py-3">{{ $loan->term_months }} months</td>
                                        <td class="px-4 py-3 text-right mono font-medium">TZS {{ number_format((float) ($loan->outstanding_balance ?? 0)) }}</td>
                                        <td class="px-4 py-3">
                                            @if ($loan->status === 'Active')
                                                <span class="inline-flex px-2 py-0.5 text-xs bg-green-100 text-green-700 border border-green-200">Active</span>
                                            @elseif($loan->status === 'Pending')
                                                <span class="inline-flex px-2 py-0.5 text-xs bg-amber-100 text-amber-700 border border-amber-200">Pending</span>
                                            @elseif($loan->status === 'Closed')
                                                <span class="inline-flex px-2 py-0.5 text-xs bg-slate-100 text-slate-600 border border-slate-200">Closed</span>
                                            @elseif($loan->status === 'Overdue')
                                                <span class="inline-flex px-2 py-0.5 text-xs bg-yellow-100 text-yellow-700 border border-yellow-200">Overdue</span>
                                            @else
                                                <span class="inline-flex px-2 py-0.5 text-xs bg-red-100 text-red-700 border border-red-200">{{ $loan->status }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @if ($loan->is_disbursed)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs bg-green-100 text-green-700 border border-green-200"
                                                    title="Expected {{ $loan->disbursement_date?->format('d M Y') ?? 'n/a' }}">
                                                    ✓ Disbursed
                                                </span>
                                            @elseif ($loan->approved_by_id)
                                                <button type="button"
                                                    class="h-8 px-3 bg-brand-600 hover:bg-brand-700 text-white text-xs font-medium"
                                                    onclick="confirmLoanDisburse({
                                                        id: {{ $loan->id }},
                                                        code: @js($loan->code),
                                                        principal: {{ (float) ($loan->principal ?? 0) }},
                                                        bank: @js(($loan->bankAccount?->bank_name ?? $loan->sourceBankAccount?->bank_name ?? 'No bank').' · '.($loan->bankAccount?->account_number ?? $loan->sourceBankAccount?->account_number ?? 'N/A')),
                                                        expectedDate: @js($loan->disbursement_date?->format('d M Y') ?? 'Not set'),
                                                        hasBank: {{ (
                                                            (($loan->loan_type ?? 'external_borrow') === 'external_borrow' && $loan->bank_id)
                                                            || (($loan->loan_type ?? '') === 'intercompany' && $loan->bank_id && $loan->source_bank_id)
                                                            || (($loan->loan_type ?? '') === 'employee' && $loan->source_bank_id)
                                                        ) ? 'true' : 'false' }},
                                                        loanType: @js($loan->loan_type ?? 'external_borrow')
                                                    })">
                                                    Confirm Disbursement
                                                </button>
                                            @else
                                                <span class="text-xs text-amber-600 font-medium" title="Approval required before disbursement">
                                                    Awaiting Approval
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center gap-3">
                                                <button type="button" onclick="toggleLoanDetails('{{ $loan->id }}')"
                                                    class="inline-flex h-8 w-8 items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50"
                                                    title="View loan details" aria-label="View loan details">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                </button>
                                                <form action="{{ url('/loans/'.$loan->id.'/schedule/regenerate') }}" method="POST"
                                                    onsubmit="return confirm('Regenerate the repayment schedule for {{ $loan->code }}? This replaces any existing installments.');">
                                                    @csrf
                                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center border border-slate-200 text-brand-700 hover:bg-brand-50"
                                                        title="Regenerate repayment schedule" aria-label="Regenerate repayment schedule">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="loan-details-{{ $loan->id }}" class="hidden bg-slate-50/70 loan-row" data-company="{{ $loan->company?->name ?? '-' }}">
                                        <td colspan="11" class="px-4 py-4">
                                            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                                                <div class="border border-slate-200 bg-white p-3">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Target Bank Account</p>
                                                    <p class="mt-1 text-sm text-slate-700 font-medium">{{ $loan->bankAccount?->bank_name ?? '-' }} ({{ $loan->bankAccount?->account_number ?? 'No account assigned' }})</p>
                                                </div>
                                                <div class="border border-slate-200 bg-white p-3">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Purpose</p>
                                                    <p class="mt-1 text-sm text-slate-700">{{ $loan->purpose ?? '-' }}</p>
                                                </div>
                                                <div class="border border-slate-200 bg-white p-3">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Collateral</p>
                                                    <p class="mt-1 text-sm text-slate-700">{{ $loan->collateral ?? '-' }}</p>
                                                </div>
                                                <div class="border border-slate-200 bg-white p-3">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Guarantor</p>
                                                    <p class="mt-1 text-sm text-slate-700">{{ $loan->guarantor ?? '-' }}</p>
                                                </div>
                                                <div class="border border-slate-200 bg-white p-3">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Approved By</p>
                                                    <p class="mt-1 text-sm text-slate-700">{{ $loan->approvedBy?->name ?? 'Not Approved' }}</p>
                                                </div>
                                                <div class="border border-slate-200 bg-white p-3">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Expected Disbursement</p>
                                                    <p class="mt-1 text-sm text-slate-700">{{ $loan->disbursement_date?->format('d M Y') ?? 'Not set' }}</p>
                                                </div>
                                                <div class="border border-slate-200 bg-white p-3">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Disbursement Status</p>
                                                    <p class="mt-1 text-sm text-slate-700">{{ $loan->is_disbursed ? 'Confirmed' : 'Not confirmed' }}</p>
                                                </div>
                                                <div class="border border-slate-200 bg-white p-3">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Maturity Date</p>
                                                    <p class="mt-1 text-sm text-slate-700">{{ $loan->maturity_date?->format('d M Y') ?? '-' }}</p>
                                                </div>
                                                <div class="border border-slate-200 bg-white p-3">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Interest Payable</p>
                                                    <p class="mt-1 text-sm text-slate-700">TZS {{ number_format((float) ($loan->total_interest_payable ?? 0)) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-4 py-3 text-center text-slate-500">No loans recorded</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ============================= REPAYMENT SCHEDULE ============================= --}}
                <div id="loan-tab-schedule" class="loan-tab-panel hidden">
                    <div class="bg-white shadow-sm overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                                <tr>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Loan Code</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Installments</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Next Due Date</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Paid</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Pending</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Overdue</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Outstanding</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($loans ?? [] as $loan)
                                    @php
                                        $installments = $loan->repaymentSchedule;
                                        $paidCount = $installments->where('status', 'Paid')->count();
                                        $pendingCount = $installments->where('status', 'Pending')->count();
                                        $overdueCount = $installments->where('status', 'Overdue')->count();
                                        $nextDue = $installments->where('status', '!=', 'Paid')->sortBy('due_date')->first();
                                    @endphp
                                    <tr class="hover:bg-slate-50 loan-row" data-company="{{ $loan->company?->name ?? '-' }}">
                                        <td class="px-4 py-3 mono text-xs text-slate-500">{{ $loan->code }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex px-2 py-0.5 text-xs bg-brand-50 text-brand-700 border border-brand-100">{{ $loan->company?->name ?? '-' }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-right mono">{{ $installments->count() }}</td>
                                        <td class="px-4 py-3">
                                            @if ($nextDue)
                                                {{ $nextDue->due_date?->format('d M Y') ?? '-' }}
                                                @if ($nextDue->status === 'Overdue')
                                                    <span class="ml-1 inline-flex px-2 py-0.5 text-xs bg-red-100 text-red-700 border border-red-200">Overdue</span>
                                                @endif
                                            @else
                                                <span class="text-slate-400">All paid</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-right mono text-green-700">{{ $paidCount }}</td>
                                        <td class="px-4 py-3 text-right mono text-yellow-700">{{ $pendingCount }}</td>
                                        <td class="px-4 py-3 text-right mono text-red-700">{{ $overdueCount }}</td>
                                        <td class="px-4 py-3 text-right mono font-medium">TZS {{ number_format((float) ($loan->outstanding_balance ?? 0)) }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center">
                                                <button type="button" onclick="toggleScheduleDetails('{{ $loan->id }}')"
                                                    class="inline-flex h-8 w-8 items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50"
                                                    title="View installments" aria-label="View installments">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="schedule-details-{{ $loan->id }}" class="hidden bg-slate-50/70 loan-row" data-company="{{ $loan->company?->name ?? '-' }}">
                                        <td colspan="9" class="px-4 py-4">
                                            @if ($installments->isEmpty())
                                                <p class="text-sm text-slate-500 px-2">No installments generated for this loan yet.</p>
                                            @else
                                                <table class="w-full text-sm border border-slate-200">
                                                    <thead class="bg-brand-50 text-brand-700">
                                                        <tr>
                                                            <th class="px-3 py-2 text-right text-xs font-semibold uppercase text-slate-500">#</th>
                                                            <th class="px-3 py-2 text-left text-xs font-semibold uppercase text-slate-500">Due Date</th>
                                                            <th class="px-3 py-2 text-right text-xs font-semibold uppercase text-slate-500">Principal</th>
                                                            <th class="px-3 py-2 text-right text-xs font-semibold uppercase text-slate-500">Interest</th>
                                                            <th class="px-3 py-2 text-right text-xs font-semibold uppercase text-slate-500">Total</th>
                                                            <th class="px-3 py-2 text-left text-xs font-semibold uppercase text-slate-500">Status</th>
                                                            <th class="px-3 py-2 text-left text-xs font-semibold uppercase text-slate-500">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-slate-100">
                                                        @foreach ($installments as $installment)
                                                            <tr>
                                                                <td class="px-3 py-2 text-right mono">{{ $installment->installment_number }}</td>
                                                                <td class="px-3 py-2">{{ $installment->due_date?->format('d M Y') ?? '-' }}</td>
                                                                <td class="px-3 py-2 text-right mono">TZS {{ number_format((float) ($installment->principal_portion ?? 0)) }}</td>
                                                                <td class="px-3 py-2 text-right mono">TZS {{ number_format((float) ($installment->interest_portion ?? 0)) }}</td>
                                                                <td class="px-3 py-2 text-right mono font-medium">TZS {{ number_format((float) ($installment->total_installment ?? 0)) }}</td>
                                                                <td class="px-3 py-2">
                                                                    @if ($installment->status === 'Paid')
                                                                        <span class="inline-flex px-2 py-0.5 text-xs bg-green-100 text-green-700 border border-green-200">Paid</span>
                                                                    @elseif($installment->status === 'Overdue')
                                                                        <span class="inline-flex px-2 py-0.5 text-xs bg-red-100 text-red-700 border border-red-200">Overdue</span>
                                                                    @else
                                                                        <span class="inline-flex px-2 py-0.5 text-xs bg-yellow-100 text-yellow-700 border border-yellow-200">Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td class="px-3 py-2">
                                                                    @if ($installment->status !== 'Paid')
                                                                        <form action="{{ url('/loans/schedule/'.$installment->id.'/mark-paid') }}" method="POST"
                                                                            onsubmit="return confirm('Mark installment #{{ $installment->installment_number }} as paid?');">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button type="submit" class="text-brand-700 hover:text-brand-800 text-xs font-medium">Mark Paid</button>
                                                                        </form>
                                                                    @else
                                                                        <span class="text-xs text-slate-400">—</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-3 text-center text-slate-500">No loans recorded</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ============================= REPAYMENTS ============================= --}}
                <div id="loan-tab-repayments" class="loan-tab-panel hidden">
                    <div class="bg-white shadow-sm overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                                <tr>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Date</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Loan Code</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Amount Paid</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Principal</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Interest</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Method</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Balance After</th>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Recorded By</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($repayments ?? [] as $repayment)
                                    <tr class="hover:bg-slate-50 loan-row" data-company="{{ $repayment['company'] }}">
                                        <td class="px-4 py-3">{{ $repayment['date'] }}</td>
                                        <td class="px-4 py-3 mono text-xs text-slate-500">{{ $repayment['loan_code'] }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex px-2 py-0.5 text-xs bg-brand-50 text-brand-700 border border-brand-100">{{ $repayment['company'] }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-right mono font-medium">TZS {{ number_format($repayment['amount_paid']) }}</td>
                                        <td class="px-4 py-3 text-right mono">TZS {{ number_format($repayment['principal_paid']) }}</td>
                                        <td class="px-4 py-3 text-right mono">TZS {{ number_format($repayment['interest_paid']) }}</td>
                                        <td class="px-4 py-3">{{ $repayment['payment_method'] }}</td>
                                        <td class="px-4 py-3 text-right mono">TZS {{ number_format($repayment['balance_after']) }}</td>
                                        <td class="px-4 py-3">{{ $repayment['recorded_by'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-3 text-center text-slate-500">No repayments recorded</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ============================= INTEREST SUMMARY ============================= --}}
                <div id="loan-tab-summary" class="loan-tab-panel hidden">
                    <div class="bg-white shadow-sm overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                                <tr>
                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Active Loans</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Total Principal</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Interest Accrued</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Total Paid</th>
                                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Outstanding Balance</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($interestSummary ?? [] as $summary)
                                    <tr class="hover:bg-slate-50 loan-row" data-company="{{ $summary['company'] }}">
                                        <td class="px-4 py-3 font-medium">{{ $summary['company'] }}</td>
                                        <td class="px-4 py-3 text-right mono">{{ $summary['active_loans'] }}</td>
                                        <td class="px-4 py-3 text-right mono">TZS {{ number_format($summary['total_principal']) }}</td>
                                        <td class="px-4 py-3 text-right mono">TZS {{ number_format($summary['interest_accrued']) }}</td>
                                        <td class="px-4 py-3 text-right mono">TZS {{ number_format($summary['total_paid']) }}</td>
                                        <td class="px-4 py-3 text-right mono font-semibold">TZS {{ number_format($summary['outstanding_balance']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-3 text-center text-slate-500">No loan data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>
</main>

    @include('loans.modals.add-loan')

    <form id="loanDisburseForm" method="POST" class="hidden">
        @csrf
    </form>
<script>
        function confirmLoanDisburse(loan) {
            if (!loan.hasBank) {
                if (typeof openConfirm === 'function') {
                    openConfirm({
                        title: 'Bank account required',
                        message: `Loan ${loan.code} has no receiving bank account. Assign one before disbursing.`,
                        confirmText: 'OK',
                        cancelText: 'Close',
                        variant: 'warning',
                        onConfirm: () => {},
                    });
                } else {
                    alert(`Loan ${loan.code} has no receiving bank account.`);
                }
                return;
            }

            const amount = Number(loan.principal || 0).toLocaleString();
            const typeMsg = loan.loanType === 'intercompany'
                ? `TZS ${amount} will move from the lending bank to the borrowing bank.`
                : (loan.loanType === 'employee'
                    ? `TZS ${amount} will be paid out from ${loan.bank}.`
                    : `TZS ${amount} will be credited to ${loan.bank}.`);
            openConfirm({
                title: 'Confirm disbursement',
                message: `Confirm that ${loan.code} has been disbursed (expected ${loan.expectedDate})? ${typeMsg}`,
                confirmText: 'Confirm disbursement',
                cancelText: 'Cancel',
                variant: 'success',
                onConfirm: () => {
                    const form = document.getElementById('loanDisburseForm');
                    form.action = `/loans/${loan.id}/disburse`;
                    form.submit();
                },
            });
        }
        const loanTabTitles = {
            register: 'Loan Register',
            schedule: 'Repayment Schedule',
            repayments: 'Repayments',
            summary: 'Interest Summary'
        };

        const loanAddButtons = {
            register: { label: 'Add Loan', modal: 'modal-add-loan' }
        };

        function renderLoanActionButton(tab) {
            const container = document.getElementById('loanActionButton');
            if (!container) return;

            const config = loanAddButtons[tab];
            if (!config) {
                container.innerHTML = '';
                return;
            }

            container.innerHTML = `<button type="button" onclick="openLoanModal('${config.modal}')" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">${config.label}</button>`;
        }

        function switchLoanTab(tab, btn) {
            document.querySelectorAll('.loan-tab-panel').forEach(panel => panel.classList.add('hidden'));
            document.getElementById(`loan-tab-${tab}`).classList.remove('hidden');

            document.querySelectorAll('.loan-tab-btn').forEach(b => {
                b.classList.remove('bg-brand-600', 'text-white');
                b.classList.add('text-brand-700');
                b.querySelector('span')?.classList.replace('bg-white', 'bg-brand-50');
            });
            btn.classList.add('bg-brand-600', 'text-white');
            btn.classList.remove('text-brand-700');
            btn.querySelector('span')?.classList.replace('bg-brand-50', 'bg-white');

            document.getElementById('loanSectionTitle').textContent = loanTabTitles[tab];
            renderLoanActionButton(tab);
        }

        function toggleLoanDetails(id) {
            const detailsRow = document.getElementById(`loan-details-${id}`);
            if (detailsRow) {
                detailsRow.classList.toggle('hidden');
            }
        }

        function toggleScheduleDetails(id) {
            const detailsRow = document.getElementById(`schedule-details-${id}`);
            if (detailsRow) {
                detailsRow.classList.toggle('hidden');
            }
        }

        function filterLoansByCompany(company) {
            document.querySelectorAll('.loan-row').forEach(row => {
                const matches = company === 'all' || row.dataset.company === company;
                row.classList.toggle('hidden', !matches);
            });
        }

        function openLoanModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.remove('hidden');
        }

        function closeLoanModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => renderLoanActionButton('register'));
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^="modal-add-"]').forEach(m => m.classList.add('hidden'));
            }
        });
    </script>
@endsection
