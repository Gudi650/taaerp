@php
    use App\Services\AccessControlService;

    $currentUser = auth()->user();
    $SuperManager = $currentUser->role?->name === 'Manager' && $currentUser->company?->name === 'Goodness Group';
    $isAlwaysAuthorized = $currentUser && $currentUser->role && in_array($currentUser->role->name, ['Admin', 'CEO']) || $SuperManager;
    $accountant = $currentUser?->role?->name === 'Accountant' ? $currentUser : null;
    $manager = $currentUser?->role?->name === 'Manager' ? $currentUser : null;
    $isAdmin = $currentUser?->role?->name === 'Admin' ? $currentUser : null;
    $isHR = app(AccessControlService::class)->isHrManager($currentUser);
    $canMoney = $isAlwaysAuthorized || $accountant || $manager;
    $nav = 'nav-link flex items-center gap-3 mx-2 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-brand-700 transition-colors';
    $userName = $currentUser?->name ?? 'User';
    $userInitial = strtoupper(substr($userName, 0, 1));
    $userRole = $currentUser?->role?->name ?? 'N/A';
@endphp

<div id="sidebarBackdrop" class="fixed inset-0 bg-transparent z-30 lg:hidden hidden" onclick="toggleSidebar()"></div>

<div id="sidebar" class="fixed left-0 top-16 lg:top-0 w-64 h-screen bg-white border-r border-slate-200 flex flex-col transition-transform duration-300 z-40 lg:translate-x-0 -translate-x-full overflow-y-auto">
    <div class="h-16 px-4 border-b border-slate-200 flex items-center shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-brand-600 flex items-center justify-center">
                <img src="{{ asset('favicon.png') }}" alt="{{ company_name() }} logo" class="w-8 h-8 object-contain brightness-0 invert" />
            </div>
            <div>
                <p class="font-semibold text-brand-700 font-display text-sm">{{ company_name() }}</p>
                <p class="text-xs text-slate-500">{{ company_tagline() }}</p>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-1 py-3 overflow-y-auto">
        <p class="px-5 pt-2 pb-1 text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">Overview</p>
        <a href="/dashboard" class="{{ $nav }}" data-path="/dashboard">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 4l9 6.5V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1v-9.5z"/></svg>
            Dashboard
        </a>

        <p class="px-5 pt-4 pb-1 text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">Workspace</p>
        @if ($isHR || $isAdmin)
            <a href="/users" class="{{ $nav }}" data-path="/users">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 20a8 8 0 0116 0"/></svg>
                Users
            </a>
            <a href="/companies" class="{{ $nav }}" data-path="/companies">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
                Companies
            </a>
        @endif
        <a href="/hrm" class="{{ $nav }}" data-path="/hrm">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-4M10 6V5a2 2 0 114 0v1m-4 0h4M8 14h8"/></svg>
            HRM
        </a>

        @if ($canMoney)
            <p class="px-5 pt-4 pb-1 text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">Money</p>
            <a href="/finance" class="{{ $nav }}" data-path="/finance">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.7 0-3 .9-3 2s1.3 2 3 2 3 .9 3 2-1.3 2-3 2m0-8V7m0 9v1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Finance
            </a>
            <a href="/sales" class="{{ $nav }}" data-path="/sales">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 6h14M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/></svg>
                Sales
            </a>
            <a href="/equity" class="{{ $nav }}" data-path="/equity">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m-7-7h14M7 8l-2 4h4L7 8zm10 0l-2 4h4l-2-4z"/></svg>
                Equity
            </a>
            <a href="/loans" class="{{ $nav }}" data-path="/loans">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M4 10h16v11H4V10zm0 0l8-6 8 6M8 21v-4m4 4v-4m4 4v-4"/></svg>
                Loans
            </a>
            <a href="/vataccount" class="{{ $nav }}" data-path="/vataccount">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l2 2 4-4M7 4h10l2 4H5l2-4zm-2 4h14v12H5V8z"/></svg>
                VAT Account
            </a>

            <p class="px-5 pt-4 pb-1 text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">Operations</p>
            <a href="/inventory" class="{{ $nav }}" data-path="/inventory">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-4-9 4 9 4 9-4zM3 7.5v9l9 4 9-4v-9"/></svg>
                Inventory
            </a>
            <a href="/far" class="{{ $nav }}" data-path="/far">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5h9M9 9h9M9 13h9M9 17h9M5 5h.01M5 9h.01M5 13h.01M5 17h.01"/></svg>
                Fixed Assets
            </a>
            <a href="/reports" class="{{ $nav }}" data-path="/reports">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19V9m6 10V5m6 14v-7m6 7V3"/></svg>
                Reports
            </a>
        @endif

        <p class="px-5 pt-4 pb-1 text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">Account</p>
        <a href="/communication" class="{{ $nav }}" data-path="/communication">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4-4 7.5-9 7.5a9.7 9.7 0 01-4-.8L3 20l1.4-3.4A7.5 7.5 0 013 12c0-4 4-7.5 9-7.5s9 3.5 9 7.5z"/></svg>
            Communication
        </a>
        <a href="/settings" class="{{ $nav }}" data-path="/settings">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.3 4.3a1.7 1.7 0 013.4 0 1.7 1.7 0 002.6 1.1 1.7 1.7 0 012.3 2.3 1.7 1.7 0 001.1 2.6 1.7 1.7 0 010 3.4 1.7 1.7 0 00-1.1 2.6 1.7 1.7 0 01-2.3 2.3 1.7 1.7 0 00-2.6 1.1 1.7 1.7 0 01-3.4 0 1.7 1.7 0 00-2.6-1.1 1.7 1.7 0 01-2.3-2.3 1.7 1.7 0 00-1.1-2.6 1.7 1.7 0 010-3.4 1.7 1.7 0 001.1-2.6 1.7 1.7 0 012.3-2.3 1.7 1.7 0 002.6-1.1z"/><circle cx="12" cy="12" r="3"/></svg>
            Settings
        </a>
    </nav>

    <div class="p-3 border-t border-slate-200 bg-white sticky bottom-0">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-brand-600 flex items-center justify-center text-white font-bold text-xs font-display shrink-0">{{ $userInitial }}</div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-slate-800 truncate">{{ $userName }}</p>
                <p class="text-xs text-slate-500 truncate">{{ $userRole }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Logout">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function setActiveNavLink() {
        const path = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(link => {
            const linkPath = link.getAttribute('data-path');
            const on = path === linkPath || path.startsWith(linkPath + '/');
            link.classList.toggle('bg-brand-600', on);
            link.classList.toggle('text-white', on);
            link.classList.toggle('text-slate-600', !on);
            link.classList.toggle('hover:bg-slate-50', !on);
            link.classList.toggle('hover:text-brand-700', !on);
        });
    }
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const isHidden = sidebar.classList.toggle('-translate-x-full');
        if (backdrop) backdrop.classList.toggle('hidden', isHidden);
    }
    document.addEventListener('DOMContentLoaded', setActiveNavLink);
</script>
