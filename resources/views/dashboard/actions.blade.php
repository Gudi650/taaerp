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
