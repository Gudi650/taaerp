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
