@extends('layouts.app')

@section('title', 'VAT Account')

@section('content')
@php
    $netLabel = ($vatPayable ?? 0) > 0 ? 'VAT Payable' : 'VAT Receivable';
    $netClass = ($vatPayable ?? 0) > 0 ? 'text-brand-700' : 'text-red-600';
@endphp

<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2 mb-8">
        <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-brand-600">Tax</p>
            <h1 class="font-display text-2xl font-semibold text-brand-700">VAT Account</h1>
        </div>
        <p class="text-sm text-slate-500">Period: <span class="font-medium text-slate-700">{{ $period ?? '—' }}</span></p>
    </div>

    <div class="grid gap-4 md:grid-cols-3 mb-8">
        <div class="bg-white p-5 border-l-4 border-l-brand-600 shadow-sm">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Output VAT (Sales)</p>
            <p class="mt-2 text-2xl font-semibold text-brand-700 mono">TZS {{ number_format($outputVat ?? 0, 0) }}</p>
            <p class="mt-1 text-xs text-slate-500">VAT collected on sales</p>
        </div>
        <div class="bg-white p-5 border-l-4 border-l-brand-600 shadow-sm">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Input VAT (Purchases)</p>
            <p class="mt-2 text-2xl font-semibold text-brand-700 mono">TZS {{ number_format($inputVat ?? 0, 0) }}</p>
            <p class="mt-1 text-xs text-slate-500">VAT paid on purchases</p>
        </div>
        <div class="bg-white p-5 border-l-4 border-l-brand-600 shadow-sm">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">{{ $netLabel }}</p>
            <p class="mt-2 text-2xl font-semibold mono {{ $netClass }}">TZS {{ number_format(abs($vatPayable ?? 0), 0) }}</p>
            <p class="mt-1 text-xs text-slate-500">Input VAT − Output VAT</p>
        </div>
    </div>

    <section class="bg-white shadow-sm mb-6 overflow-x-auto">
        <div class="px-5 py-4">
            <h2 class="font-display text-lg font-semibold text-brand-700">Output VAT</h2>
            <p class="text-xs text-slate-500 mt-0.5">VAT on sales invoices</p>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Ref No.</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Customer</th>
                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Taxable Value</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">VAT Rate</th>
                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">VAT Amount</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Date</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($outputRows ?? []) as $row)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-5 py-3 mono text-xs text-slate-500">{{ $row['ref_no'] }}</td>
                        <td class="px-5 py-3 font-medium text-slate-800">{{ $row['name'] }}</td>
                        <td class="px-5 py-3 text-right mono">TZS {{ number_format($row['taxable_value'], 0) }}</td>
                        <td class="px-5 py-3">{{ $row['vat_rate'] }}%</td>
                        <td class="px-5 py-3 text-right mono text-brand-700 font-medium">TZS {{ number_format($row['vat_amount'], 0) }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $row['date'] }}</td>
                        <td class="px-5 py-3"><span class="inline-flex px-2 py-0.5 text-xs font-medium {{ $row['status_class'] }}">{{ ucfirst($row['status']) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-sm text-slate-500">No output VAT records for this period.</td></tr>
                @endforelse
            </tbody>
            <tfoot class="bg-slate-50">
                <tr>
                    <td colspan="4" class="px-5 py-3 text-right text-sm font-semibold text-slate-600">Total Output VAT</td>
                    <td class="px-5 py-3 text-right font-semibold mono text-brand-700">TZS {{ number_format($outputVat ?? 0, 0) }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </section>

    <section class="bg-white shadow-sm mb-6 overflow-x-auto">
        <div class="px-5 py-4">
            <h2 class="font-display text-lg font-semibold text-brand-700">Input VAT</h2>
            <p class="text-xs text-slate-500 mt-0.5">VAT on purchases</p>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Ref No.</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Supplier</th>
                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Taxable Value</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">VAT Rate</th>
                    <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">VAT Amount</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Date</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($inputRows ?? []) as $row)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-5 py-3 mono text-xs text-slate-500">{{ $row['ref_no'] }}</td>
                        <td class="px-5 py-3 font-medium text-slate-800">{{ $row['name'] }}</td>
                        <td class="px-5 py-3 text-right mono">TZS {{ number_format($row['taxable_value'], 0) }}</td>
                        <td class="px-5 py-3">{{ $row['vat_rate'] }}%</td>
                        <td class="px-5 py-3 text-right mono text-brand-700 font-medium">TZS {{ number_format($row['vat_amount'], 0) }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $row['date'] }}</td>
                        <td class="px-5 py-3"><span class="inline-flex px-2 py-0.5 text-xs font-medium {{ $row['status_class'] }}">{{ ucfirst($row['status']) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-sm text-slate-500">No input VAT records for this period.</td></tr>
                @endforelse
            </tbody>
            <tfoot class="bg-slate-50">
                <tr>
                    <td colspan="4" class="px-5 py-3 text-right text-sm font-semibold text-slate-600">Total Input VAT</td>
                    <td class="px-5 py-3 text-right font-semibold mono text-brand-700">TZS {{ number_format($inputVat ?? 0, 0) }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </section>

    <section class="bg-white shadow-sm p-5">
        <h3 class="font-display text-lg font-semibold text-brand-700 mb-4">VAT Reconciliation</h3>
        <div class="grid sm:grid-cols-3 gap-6 text-sm">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Total Output VAT</p>
                <p class="mt-1 mono font-semibold text-slate-800">TZS {{ number_format($outputVat ?? 0, 0) }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Total Input VAT</p>
                <p class="mt-1 mono font-semibold text-slate-800">TZS {{ number_format($inputVat ?? 0, 0) }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">{{ $netLabel }}</p>
                <p class="mt-1 mono font-semibold {{ $netClass }}">TZS {{ number_format(abs($vatPayable ?? 0), 0) }}</p>
            </div>
        </div>
    </section>
</main>
@endsection
