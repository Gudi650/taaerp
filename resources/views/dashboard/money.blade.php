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
