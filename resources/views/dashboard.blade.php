@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $icon = [
        'building' => 'M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6',
        'people' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 20a8 8 0 0116 0',
        'doc' => 'M7 3h7l5 5v13H7V3zM14 3v5h5',
        'list' => 'M4 6h16M4 10h16M4 14h10M4 18h6',
        'cal' => 'M8 3v3M16 3v3M4 8h16M5 6h14a1 1 0 011 1v12a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1z',
        'box' => 'M21 16V8l-9-5-9 5v8l9 5 9-5zM3 8l9 5 9-5M12 13v8',
        'cart' => 'M4 6h2l2 10h10l2-7H8M8 21a1 1 0 100-2 1 1 0 000 2zM18 21a1 1 0 100-2 1 1 0 000 2z',
        'sign' => 'M14 3h7v7M21 3l-9 9M10 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-4',
    ];
    $activeCompanies = $companies->where('status', 'Active')->count();
    $maxHeadcount = max(1, (int) $companies->max('users_count'));
    $kpis = [
        ['Companies', $totalCompanies, $activeCompanies.' active', $icon['building']],
        ['Employees', $totalEmployees, 'in '.$totalCompanies.' compan'.((int) $totalCompanies === 1 ? 'y' : 'ies'), $icon['people']],
        ['Invoices', $totalInvoices, $pendingInvoices.' pending', $icon['doc']],
        ['Expenses', $totalExpenses, $pendingExpenses.' pending', $icon['list']],
    ];
    $attentionItems = array_values(array_filter([
        ['Invoice approvals', (int) ($pendingInvoices ?? 0), route('invoices.index'), $icon['doc']],
        ['Expense approvals', (int) ($pendingExpenses ?? 0), route('finance'), $icon['list']],
        ['Leave requests', (int) ($pendingLeaves ?? 0), route('hrm'), $icon['cal']],
        ['Low stock items', (int) ($lowStockItems ?? 0), route('inventory'), $icon['box']],
    ], fn ($i) => $i[1] > 0));
    usort($attentionItems, fn ($a, $b) => $b[1] <=> $a[1]);
    $attentionTotal = array_sum(array_column($attentionItems, 1));
    $actions = [
        ['invoices.index', 'Create invoice', $icon['doc'], true],
        ['finance', 'Record expense', $icon['list'], false],
        ['hrm', 'Review leaves', $icon['cal'], false],
        ['sales', 'New order', $icon['cart'], false],
        ['inventory', 'Add product', $icon['box'], false],
        ['sales', 'New contract', $icon['sign'], false],
    ];
@endphp

<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">
    <section class="bg-brand-600 text-white mb-6">
        <div class="grid sm:grid-cols-2">
            <div class="p-6 sm:border-r sm:border-brand-500">
                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-brand-100">Invoice value</p>
                <p class="mt-2 text-2xl lg:text-3xl font-semibold font-display mono">TZS {{ number_format($totalInvoiceAmount ?? 0, 0) }}</p>
                <p class="mt-1 text-xs text-brand-100">{{ $totalInvoices }} invoice{{ (int) $totalInvoices === 1 ? '' : 's' }}</p>
            </div>
            <div class="p-6 border-t border-brand-500 sm:border-t-0">
                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-brand-100">Expense value</p>
                <p class="mt-2 text-2xl lg:text-3xl font-semibold font-display mono">TZS {{ number_format($totalExpenseAmount ?? 0, 0) }}</p>
                <p class="mt-1 text-xs text-brand-100">{{ $totalExpenses }} expense{{ (int) $totalExpenses === 1 ? '' : 's' }}</p>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach ($kpis as [$label, $value, $hint, $d])
            <div class="bg-white p-5 border-l-4 border-l-brand-600 shadow-sm flex items-start justify-between gap-3">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-2xl font-semibold text-brand-700 font-display">{{ $value }}</p>
                    <p class="mt-1 text-xs {{ str_contains($hint, 'pending') && (int) $hint > 0 ? 'text-red-600' : 'text-slate-500' }}">{{ $hint }}</p>
                </div>
                <span class="w-9 h-9 bg-brand-50 text-brand-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $d }}"/></svg>
                </span>
            </div>
        @endforeach
    </div>

    @if (!empty($pendingReviewCount ?? 0) && !empty($firstPendingReviewExpenseId))
        <div class="mb-6 bg-white shadow-sm border-l-4 border-l-red-600 px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-sm font-semibold text-brand-700">Expense review needed</p>
                <p class="text-sm text-slate-500 mt-0.5">{{ $pendingReviewCount }} expense{{ $pendingReviewCount === 1 ? '' : 's' }} waiting for your feedback.</p>
            </div>
            <a href="{{ route('expenses.review', ['expense' => $firstPendingReviewExpenseId]) }}" class="inline-flex items-center justify-center h-9 px-4 bg-brand-600 text-white text-sm font-medium hover:bg-brand-700">Review now</a>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
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

        <aside class="space-y-6">
            <section class="bg-white shadow-sm">
                <div class="px-5 pt-5 pb-2 flex items-center justify-between gap-3">
                    <h3 class="font-display text-lg font-semibold text-brand-700">Needs attention</h3>
                    <span class="px-2 py-0.5 text-[11px] font-semibold {{ $attentionTotal ? 'bg-red-50 text-red-600' : 'bg-slate-50 text-slate-500' }}">{{ $attentionTotal }}</span>
                </div>
                <ul>
                    @forelse ($attentionItems as [$label, $count, $href, $d])
                        <li class="border-t border-slate-100">
                            <a href="{{ $href }}" class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50">
                                <span class="w-8 h-8 shrink-0 bg-brand-50 text-brand-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $d }}"/></svg>
                                </span>
                                <span class="flex-1 text-sm font-medium text-slate-800">{{ $label }}</span>
                                <span class="px-2 py-0.5 text-[11px] font-semibold tabular-nums bg-red-50 text-red-600">{{ $count }}</span>
                                <svg class="w-4 h-4 shrink-0 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-sm text-slate-500 border-t border-slate-100">All clear</li>
                    @endforelse
                </ul>
            </section>

            <section class="bg-white shadow-sm p-5">
                <h3 class="font-display text-lg font-semibold text-brand-700 mb-3">Quick actions</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($actions as [$route, $label, $d, $primary])
                        <a href="{{ route($route) }}" class="flex items-center gap-2 px-3 py-2.5 text-sm font-medium {{ $primary ? 'bg-brand-600 text-white hover:bg-brand-700' : 'bg-brand-50 text-brand-700 hover:bg-brand-100' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $d }}"/></svg>
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="bg-white shadow-sm">
                <div class="px-5 pt-5 pb-2 flex items-center justify-between gap-3">
                    <h3 class="font-display text-lg font-semibold text-brand-700">Recent invoices</h3>
                    <a href="{{ route('invoices.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">View all</a>
                </div>
                <div class="max-h-64 overflow-y-auto">
                    @forelse ($recentInvoices as $invoice)
                        @php
                            $status = strtolower($invoice->status ?? 'pending');
                            $isPaid = $status === 'paid';
                            $due = $invoice->due_date ? \Illuminate\Support\Carbon::parse($invoice->due_date) : null;
                            $isOverdue = $status === 'overdue' || (! $isPaid && $due && $due->isPast());
                            $stripe = $isPaid ? 'border-l-brand-600' : ($isOverdue ? 'border-l-red-600' : 'border-l-slate-300');
                            $pill = $isPaid
                                ? 'bg-brand-50 text-brand-700'
                                : ($isOverdue ? 'bg-red-50 text-red-600' : 'bg-slate-50 text-slate-600');
                            $label = $isOverdue && $status !== 'overdue' ? 'Overdue' : ucfirst($status);
                            $shownDate = $invoice->invoice_date ?? $invoice->created_at;
                        @endphp
                        <div class="flex items-center gap-3 px-5 py-3 border-l-4 {{ $stripe }}">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs mono text-slate-500 truncate">{{ $invoice->invoice_number }}</p>
                                @if ($invoice->client_name)
                                    <p class="text-xs text-slate-400 truncate">{{ $invoice->client_name }}</p>
                                @endif
                            </div>
                            <p class="text-sm font-medium text-slate-800 mono shrink-0">TZS {{ number_format($invoice->total_amount ?? 0, 0) }}</p>
                            <span class="shrink-0 px-2 py-0.5 text-[11px] font-medium {{ $pill }}">{{ $label }}</span>
                            <p class="hidden sm:block w-16 text-right text-[11px] text-slate-400 shrink-0">{{ $shownDate ? \Illuminate\Support\Carbon::parse($shownDate)->format('d M') : '—' }}</p>
                        </div>
                    @empty
                        <p class="px-5 py-8 text-sm text-slate-500">No recent invoices</p>
                    @endforelse
                </div>
            </section>
        </aside>
    </div>
</main>
@endsection
