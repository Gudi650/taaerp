<div id="topbar" class="fixed top-0 left-0 right-0 lg:left-64 h-16 bg-white border-b border-slate-200 z-50 flex items-center justify-between px-4 lg:px-6">
    
    <div class="flex items-center gap-2 min-w-0">
        <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 shrink-0" aria-label="Open menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <h1 class="pl-4 border-l-4 border-brand-600 text-lg lg:text-xl font-semibold text-brand-700 font-display tracking-tight truncate">{{ $pageTitle ?? 'Dashboard' }}</h1>
    </div>

    @php
        use App\Services\AccessControlService;
        $currentUser = auth()->user();
        $isSuperAccountant = $currentUser?->role?->name === 'Accountant' && $currentUser->company?->name === 'Goodness Group';
        $activeCompanyId = session('active_company_id');
        $isAlwaysAllowed = app(AccessControlService::class)->isAlwaysAllowed($currentUser);
    @endphp

    <div class="flex items-center gap-3 shrink-0">
        @if ($isAlwaysAllowed || $isSuperAccountant)
            @php
                $companyOptions = \App\Models\Company::orderBy('name')->get();
                $activeCompanyLabel = 'All Companies';
                if ($activeCompanyId) {
                    $match = $companyOptions->firstWhere('id', (int) $activeCompanyId);
                    $activeCompanyLabel = $match
                        ? ($match->name === company_name() ? company_name().' (Parent)' : $match->name)
                        : 'All Companies';
                }
            @endphp
            <div class="relative" id="companySwitch">
                <button type="button" onclick="toggleCompanyMenu(event)"
                    class="flex items-center gap-2 bg-brand-50 px-2.5 h-9 text-xs lg:text-sm text-brand-700 font-medium max-w-[12rem] lg:max-w-xs border border-transparent hover:border-brand-600">
                    <svg class="w-4 h-4 text-brand-600 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
                    <span class="truncate">{{ $activeCompanyLabel }}</span>
                    <svg class="w-3.5 h-3.5 text-brand-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
                </button>
                <div id="companyMenu" class="hidden absolute right-0 top-full mt-1 w-56 bg-brand-50 shadow-sm z-[60] py-1 max-h-72 overflow-y-auto">
                    <button type="button" onclick="pickCompany('')" class="w-full text-left px-3 py-2 text-sm font-medium {{ is_null($activeCompanyId) ? 'bg-brand-600 text-white' : 'text-brand-700 hover:bg-brand-100' }}">All Companies</button>
                    @foreach ($companyOptions as $company)
                        @php $label = $company->name === company_name() ? company_name().' (Parent)' : $company->name; @endphp
                        <button type="button" onclick="pickCompany('{{ $company->id }}')" class="w-full text-left px-3 py-2 text-sm font-medium {{ (string) $activeCompanyId === (string) $company->id ? 'bg-brand-600 text-white' : 'text-brand-700 hover:bg-brand-100' }}">{{ $label }}</button>
                    @endforeach
                </div>
                <form id="companySwitchForm" action="{{ route('active-company.store') }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="company_id" id="companySwitchInput">
                </form>
            </div>
            <script>
                function toggleCompanyMenu(e) {
                    e.stopPropagation();
                    document.getElementById('companyMenu').classList.toggle('hidden');
                }
                function pickCompany(id) {
                    document.getElementById('companySwitchInput').value = id;
                    document.getElementById('companySwitchForm').submit();
                }
                document.addEventListener('click', function () {
                    const menu = document.getElementById('companyMenu');
                    if (menu) menu.classList.add('hidden');
                });
            </script>
        @else
            <span class="hidden sm:inline-flex items-center gap-2 bg-brand-50 px-2.5 h-9 text-xs lg:text-sm text-brand-700 font-medium truncate max-w-[10rem]">
                <svg class="w-4 h-4 text-brand-600 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
                {{ $currentUser?->company?->name ?? 'No company' }}
            </span>
        @endif

        <span class="hidden sm:block w-px h-6 bg-slate-200"></span>

        <a href="{{ route('settings') }}" class="w-9 h-9 flex items-center justify-center bg-brand-50 text-brand-700 hover:bg-brand-100" title="Settings">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.3 4.3a1.7 1.7 0 013.4 0 1.7 1.7 0 002.6 1.1 1.7 1.7 0 012.3 2.3 1.7 1.7 0 001.1 2.6 1.7 1.7 0 010 3.4 1.7 1.7 0 00-1.1 2.6 1.7 1.7 0 01-2.3 2.3 1.7 1.7 0 00-2.6 1.1 1.7 1.7 0 01-3.4 0 1.7 1.7 0 00-2.6-1.1 1.7 1.7 0 01-2.3-2.3 1.7 1.7 0 00-1.1-2.6 1.7 1.7 0 010-3.4 1.7 1.7 0 001.1-2.6 1.7 1.7 0 012.3-2.3 1.7 1.7 0 002.6-1.1z"/><circle cx="12" cy="12" r="3"/></svg>
        </a>
    </div>
</div>
