@props(['for'])

<button type="button" data-password-toggle="{{ $for }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-brand-600" aria-label="Show password">
    <svg class="eye-on w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"/><circle cx="12" cy="12" r="3.25"/></svg>
    <svg class="eye-off hidden w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75l16.5 16.5M9.9 9.9A3.25 3.25 0 0012 15.25 3.25 3.25 0 0015.1 14.1M6.4 6.4C4.5 7.8 3.1 9.8 2.25 12c0 0 3.75 6.75 9.75 6.75 1.55 0 2.96-.34 4.2-.92M10.9 5.4c.36-.07.73-.15 1.1-.15 6 0 9.75 6.75 9.75 6.75a16 16 0 01-2.05 2.7"/></svg>
</button>
