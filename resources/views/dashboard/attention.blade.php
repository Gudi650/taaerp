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
