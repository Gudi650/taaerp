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
