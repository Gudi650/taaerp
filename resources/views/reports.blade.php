@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">
    <nav class="inline-flex bg-white shadow-sm mb-6">
        <button type="button" class="flex items-center gap-2 h-9 px-3 text-sm font-medium font-display bg-brand-600 text-white">
            Reports
        </button>
    </nav>

    <form method="POST" action="{{ route('reports') }}" class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4 mb-6">
      @csrf
      <div class="flex flex-col lg:flex-row gap-4 items-end">
        <div class="w-full lg:w-56">
          <label for="report_type" class="mb-1 block text-xs font-semibold uppercase text-slate-500">Report type</label>
          <select id="report_type" name="report_type" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
            <option value="expenses" @selected(($reportType ?? 'expenses') === 'expenses')>Expenses</option>
            <option value="income" @selected(($reportType ?? '') === 'income')>Income Statement</option>
            <option value="balance" @selected(($reportType ?? '') === 'balance')>Balance Sheet</option>
            <!-- #trial balance -->
            <option value="trial" @selected(($reportType ?? '') === 'trial')>Trial Balance</option>
            <!-- #cash flow -->
            <option value="cashflow" @selected(($reportType ?? '') === 'cashflow')>Cash Flow Statement</option>
            <option value="equity" @selected(($reportType ?? '') === 'equity')>Equity Statement</option>
           
          </select>
        </div>

        <div class="w-full lg:w-56">
          <label for="scope" class="mb-1 block text-xs font-semibold uppercase text-slate-500">Report scope</label>
          <select id="scope" name="scope" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
            <option value="all" @selected($selectedScope === 'all')>All Companies</option>
            <option value="company" @selected($selectedScope === 'company')>Single company</option>
          </select>
        </div>

        <div id="companyField" class="w-full lg:w-64 {{ $selectedScope === 'company' ? '' : 'hidden' }}">
          <label for="company_id" class="mb-1 block text-xs font-semibold uppercase text-slate-500">Company</label>
          <select id="company_id" name="company_id" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
            @foreach ($companies as $company)
              <option value="{{ $company->id }}" @selected((int) $selectedCompanyId === (int) $company->id)>
                {{ $company->name === 'Goodness Group' ? 'Goodness Group (Parent)' : $company->name }}
              </option>
            @endforeach
          </select>
        </div>
         {{-- Date Range --}}
        <div class="w-full lg:w-auto">
            <label for="date_filter" class="mb-1 block text-xs font-semibold uppercase text-slate-500">Period</label>

            <select
                id="date_filter"
                name="date_filter"
                class="w-full lg:w-52 h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
            >
                <option value="this_month" @selected(($dateFilter ?? 'this_month') === 'this_month')>
                    This Month
                </option>

                <option value="last_month" @selected(($dateFilter ?? '') === 'last_month')>
                    Last Month
                </option>

                <option value="this_quarter" @selected(($dateFilter ?? '') === 'this_quarter')>
                    This Quarter
                </option>

                <option value="this_year" @selected(($dateFilter ?? '') === 'this_year')>
                    This Financial Year
                </option>

                <option value="custom" @selected(($dateFilter ?? '') === 'custom')>
                    Custom Range
                </option>
            </select>
        </div>

        {{-- Custom Date Range --}}
        <div
            id="customDateFields"
            class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto {{ ($dateFilter ?? '') === 'custom' ? '' : 'hidden' }}"
        >
            <div>
                <label for="start_date" class="mb-1 block text-xs font-semibold uppercase text-slate-500">From</label>

                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    value="{{ $startDate ?? '' }}"
                    class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                >
            </div>

            <div>
                <label for="end_date" class="mb-1 block text-xs font-semibold uppercase text-slate-500">To</label>

                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    value="{{ $endDate ?? '' }}"
                    class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                >
            </div>
        </div>

        <div class="ml-auto">
          <button type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Generate</button>
        </div>
      </div>
    </form>

    @php
      $reportFilterQuery = \App\Support\ReportFilters::current()->queryString();
      $reportFilterQs = $reportFilterQuery ? '?'.$reportFilterQuery : '';
    @endphp
    @if (($reportType ?? 'expenses') === 'expenses')
      <div class="flex flex-wrap gap-3 mb-6">
        <a href="/expense-report{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-50 text-brand-700 text-sm font-medium hover:bg-brand-100">Preview Expense Report</a>
        <a href="/expense-report-export{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Export Expense Report PDF</a>
      </div>
    @elseif (($reportType ?? 'expenses') === 'balance')
      <div class="flex flex-wrap gap-3 mb-6">
        <a href="/balance-sheet{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-50 text-brand-700 text-sm font-medium hover:bg-brand-100">Preview Balance Sheet</a>
        <a href="/balance_sheet{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Export Balance Sheet PDF</a>
      </div>
    @elseif (($reportType ?? 'expenses') === 'income')
      <div class="flex flex-wrap gap-3 mb-6">
        <a href="/income-statement{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-50 text-brand-700 text-sm font-medium hover:bg-brand-100">Preview Income Statement</a>
        <a href="/income-statement-export{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Export Income Statement PDF</a>
      </div>

    @elseif (($reportType ?? '') === 'trial')
      <div class="flex flex-wrap gap-3 mb-6">
        <a href="/trial-balance{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-50 text-brand-700 text-sm font-medium hover:bg-brand-100">Preview Trial Balance</a>
        <a href="/trial-balance-export{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Export Trial Balance PDF</a>
      </div>
    @elseif (($reportType ?? '') === 'cashflow')
      <div class="flex flex-wrap gap-3 mb-6">
        <a href="/cash-flow{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-50 text-brand-700 text-sm font-medium hover:bg-brand-100">Preview Cash Flow Statement</a>
        <a href="/cash-flow-export{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Export Cash Flow Statement PDF</a>
      </div>
    @elseif (($reportType ?? '') === 'equity')
      <div class="flex flex-wrap gap-3 mb-6">
        <a href="/equity-statement{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-50 text-brand-700 text-sm font-medium hover:bg-brand-100">Preview Equity Statement</a>
        <a href="/equity-statement-export{{ $reportFilterQs }}" class="inline-flex items-center h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Export Equity Statement PDF</a>
      </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
      <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Scope</p>
        <p class="mt-2 text-lg font-semibold text-brand-700">{{ $selectedCompanyName }}</p>
      </div>
      @if (($reportType ?? 'expenses') === 'expenses')
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Expense Count</p>
          <p class="mt-2 text-2xl font-semibold text-brand-700">{{ number_format($totals['expense_count'] ?? 0) }}</p>
        </div>
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Gross Amount</p>
          <p class="mt-2 text-2xl font-semibold text-brand-700">TZS {{ number_format($totals['gross_amount'] ?? 0, 2) }}</p>
        </div>
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Net Amount</p>
          <p class="mt-2 text-2xl font-semibold text-brand-700">TZS {{ number_format($totals['net_amount'] ?? 0, 2) }}</p>
        </div>
      @elseif (($reportType ?? '') === 'income')
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Invoices</p>
          <p class="mt-2 text-2xl font-semibold text-brand-700">{{ number_format($incomeTotals['invoice_count'] ?? 0) }}</p>
        </div>
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Subtotal</p>
          <p class="mt-2 text-2xl font-semibold text-brand-700">TZS {{ number_format($incomeTotals['subtotal'] ?? 0, 2) }}</p>
        </div>
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Total</p>
          <p class="mt-2 text-2xl font-semibold text-brand-700">TZS {{ number_format($incomeTotals['total'] ?? 0, 2) }}</p>
        </div>
      @elseif (($reportType ?? '') === 'balance')
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Assets</p>
          <p class="mt-2 text-2xl font-semibold text-brand-700">TZS {{ number_format($balance['assets'] ?? 0, 2) }}</p>
        </div>
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Liabilities</p>
          <p class="mt-2 text-2xl font-semibold text-brand-700">TZS {{ number_format($balance['liabilities'] ?? 0, 2) }}</p>
        </div>
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Equity</p>
          <p class="mt-2 text-2xl font-semibold text-brand-700">TZS {{ number_format($balance['equity'] ?? 0, 2) }}</p>
        </div>
      @else
        <div class="bg-white shadow-sm border-l-4 border-l-brand-600 p-4 flex items-center text-sm text-slate-500">No summary available for this report type.</div>
      @endif
    </div>

    @if (($reportType ?? 'expenses') === 'balance')
      <div class="bg-white shadow-sm overflow-hidden mb-6">
        <div class="px-5 py-3 border-b-2 border-brand-600 bg-brand-50">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-brand-700">Assets Breakdown</p>
        </div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="bg-brand-50 p-3">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Cash</p>
            <p class="mt-1 text-lg font-semibold text-brand-700">TZS {{ number_format($balance['cash'] ?? 0, 2) }}</p>
          </div>
          <div class="bg-brand-50 p-3">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Receivables</p>
            <p class="mt-1 text-lg font-semibold text-brand-700">TZS {{ number_format($balance['receivables'] ?? 0, 2) }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm overflow-hidden mb-6">
        <div class="px-5 py-3 border-b-2 border-brand-600 bg-brand-50">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-brand-700">Liabilities Breakdown</p>
        </div>
        <div class="p-4">
          <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Total Payables</p>
          <p class="mt-1 text-lg font-semibold text-brand-700">TZS {{ number_format($balance['payables'] ?? $balance['liabilities'] ?? 0, 2) }}</p>
        </div>
      </div>
    @endif

    @if (($reportType ?? 'expenses') === 'pnl' || ($reportType ?? '') === 'pl' || ($reportType ?? '') === 'profit')
      <div class="bg-white shadow-sm p-4 mb-6">
        <p class="text-[11px] font-semibold uppercase tracking-wide text-brand-700 mb-3">Profit & Loss (last 12 months)</p>
        <canvas id="pnlChart" height="120"></canvas>
      </div>

      <div class="bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
              <tr>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Month</th>
                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Revenue</th>
                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Expenses</th>
                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Profit</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @foreach (($plLabels ?? []) as $i => $label)
                <tr>
                  <td class="px-4 py-3">{{ $label }}</td>
                  <td class="px-4 py-3 text-right">TZS {{ number_format($plRevenue[$i] ?? 0, 2) }}</td>
                  <td class="px-4 py-3 text-right">TZS {{ number_format($plExpenses[$i] ?? 0, 2) }}</td>
                  <td class="px-4 py-3 text-right">TZS {{ number_format(($plProfit[$i] ?? 0), 2) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif
    @if ($selectedScope === 'all' && ($reportType ?? 'expenses') === 'expenses')
      <div class="bg-white shadow-sm overflow-x-auto mb-6">
          <table class="w-full text-sm">
            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
              <tr>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Expenses</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Gross</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">VAT</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Net</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @forelse ($companyBreakdown as $row)
                <tr>
                  <td class="px-4 py-3 text-sm font-medium">{{ $row['company_name'] }}</td>
                  <td class="px-4 py-3 text-sm">{{ number_format($row['expense_count']) }}</td>
                  <td class="px-4 py-3 text-sm">TZS {{ number_format($row['gross_amount'], 2) }}</td>
                  <td class="px-4 py-3 text-sm">TZS {{ number_format($row['vat_amount'], 2) }}</td>
                  <td class="px-4 py-3 text-sm">TZS {{ number_format($row['net_amount'], 2) }}</td>
                </tr>
              @empty
                <tr><td colspan="5" class="px-4 py-6 text-sm text-slate-500">No expense data found.</td></tr>
              @endforelse
                </tbody>
          </table>
      </div>
      @endif

      @if ($selectedScope === 'all' && ($reportType ?? 'expenses') === 'income')
        <div class="bg-white shadow-sm overflow-x-auto mb-6">
            <table class="w-full text-sm">
              <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                <tr>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Invoices</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Subtotal</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Tax</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Total</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @forelse ($companyIncomeBreakdown as $row)
                  <tr>
                    <td class="px-4 py-3 text-sm font-medium">{{ $row['company_name'] }}</td>
                    <td class="px-4 py-3 text-sm">{{ number_format($row['invoice_count']) }}</td>
                    <td class="px-4 py-3 text-sm">TZS {{ number_format($row['subtotal'], 2) }}</td>
                    <td class="px-4 py-3 text-sm">TZS {{ number_format($row['tax'], 2) }}</td>
                    <td class="px-4 py-3 text-sm">TZS {{ number_format($row['total'], 2) }}</td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="px-4 py-6 text-sm text-slate-500">No income data found.</td></tr>
                @endforelse
              </tbody>
            </table>
        </div>
      @endif

    <div class="bg-white shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
            <tr>
              @if (($reportType ?? 'expenses') === 'expenses')
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Expense No</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Date</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Department</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Category</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Gross</th>
                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">VAT</th>
                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Net</th>
              @else
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Invoice No</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Date</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Company</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Client</th>
                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Status</th>
                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Subtotal</th>
                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Tax</th>
                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide">Total</th>
              @endif
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
              @if (($reportType ?? 'expenses') === 'expenses')
                @forelse ($expenseRows as $row)
                  <tr>
                    <td class="px-4 py-3 text-sm font-medium">{{ $row['expense_number'] }}</td>
                    <td class="px-4 py-3 text-sm">{{ $row['expense_date'] }}</td>
                    <td class="px-4 py-3 text-sm">{{ $row['company_name'] }}</td>
                    <td class="px-4 py-3 text-sm">{{ $row['department_name'] }}</td>
                    <td class="px-4 py-3 text-sm">{{ $row['category'] }}</td>
                    <td class="px-4 py-3 text-sm">{{ $row['status'] }}</td>
                    <td class="px-4 py-3 text-sm text-right">TZS {{ number_format($row['gross_amount'], 2) }}</td>
                    <td class="px-4 py-3 text-sm text-right">TZS {{ number_format($row['vat_amount'], 2) }}</td>
                    <td class="px-4 py-3 text-sm text-right">TZS {{ number_format($row['net_amount'], 2) }}</td>
                  </tr>
                @empty
                  <tr><td colspan="9" class="px-4 py-6 text-sm text-slate-500">No expenses found for this scope.</td></tr>
                @endforelse
              @else
                @forelse ($incomeRows as $row)
                  <tr>
                    <td class="px-4 py-3 text-sm font-medium">{{ $row['invoice_number'] }}</td>
                    <td class="px-4 py-3 text-sm">{{ $row['invoice_date'] }}</td>
                    <td class="px-4 py-3 text-sm">{{ $row['company_name'] }}</td>
                    <td class="px-4 py-3 text-sm">{{ $row['client'] }}</td>
                    <td class="px-4 py-3 text-sm">{{ $row['status'] }}</td>
                    <td class="px-4 py-3 text-sm text-right">TZS {{ number_format($row['subtotal'], 2) }}</td>
                    <td class="px-4 py-3 text-sm text-right">TZS {{ number_format($row['tax'], 2) }}</td>
                    <td class="px-4 py-3 text-sm text-right">TZS {{ number_format($row['total'], 2) }}</td>
                  </tr>
                @empty
                  <tr><td colspan="8" class="px-4 py-6 text-sm text-slate-500">No invoices found for this scope.</td></tr>
                @endforelse
              @endif
          </tbody>
        </table>
    </div>
  </main>

  <script>
    const scopeSelect = document.getElementById('scope');
    const companyField = document.getElementById('companyField');

    function toggleCompanyField() {
      companyField.classList.toggle('hidden', scopeSelect.value !== 'company');
    }

    scopeSelect.addEventListener('change', toggleCompanyField);
    toggleCompanyField();
  </script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    (function(){
      const reportType = '{{ $reportType ?? 'expenses' }}';
      if (['pnl','pl','profit'].includes(reportType)) {
        const labels = {!! json_encode($plLabels ?? []) !!};
        const revenue = {!! json_encode($plRevenue ?? []) !!};
        const expenses = {!! json_encode($plExpenses ?? []) !!};
        const profit = {!! json_encode($plProfit ?? []) !!};

        const ctx = document.getElementById('pnlChart').getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels,
            datasets: [
              { label: 'Revenue', data: revenue, backgroundColor: 'rgba(56,189,248,0.6)' },
              { label: 'Expenses', data: expenses, backgroundColor: 'rgba(249,115,22,0.6)' },
              { label: 'Profit', data: profit, type: 'line', borderColor: 'rgba(34,197,94,0.9)', backgroundColor: 'rgba(34,197,94,0.2)', tension: 0.3 }
            ]
          },
          options: { responsive:true, maintainAspectRatio:false, scales:{ y:{ ticks:{ callback: v => 'TZS ' + Number(v).toLocaleString() } } } }
        });
      }
    })();
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateFilter = document.getElementById('date_filter');
        const customFields = document.getElementById('customDateFields');

        function toggleCustomDates() {
            if (dateFilter.value === 'custom') {
                customFields.classList.remove('hidden');
            } else {
                customFields.classList.add('hidden');
            }
        }

        dateFilter.addEventListener('change', toggleCustomDates);

        toggleCustomDates();
    });
</script>
@endsection
