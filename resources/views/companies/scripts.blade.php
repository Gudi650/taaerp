<script>
    const addCompanyModalBackdrop = document.getElementById('addCompanyModalBackdrop');
    const addCompanyBtn = document.getElementById('addCompanyBtn');
    const closeAddCompanyModalBtn = document.getElementById('closeAddCompanyModalBtn');
    const cancelAddCompanyBtn = document.getElementById('cancelAddCompanyBtn');
    const submitCompanyBtn = document.getElementById('submitCompanyBtn');
    const companyForm = document.getElementById('companyForm');

    function openAddCompanyModal() {
        addCompanyModalBackdrop.classList.remove('hidden');
    }

    function closeAddCompanyModal() {
        addCompanyModalBackdrop.classList.add('hidden');
    }

    addCompanyBtn.addEventListener('click', openAddCompanyModal);
    closeAddCompanyModalBtn.addEventListener('click', closeAddCompanyModal);
    cancelAddCompanyBtn.addEventListener('click', closeAddCompanyModal);

    submitCompanyBtn.addEventListener('click', () => {
        openConfirm(
            'Save Company',
            'Do you want to register this company in the database?',
            () => companyForm.submit()
        );
    });

    companyForm.addEventListener('submit', (event) => {
        event.preventDefault();
        openConfirm(
            'Save Company',
            'Do you want to register this company in the database?',
            () => companyForm.submit()
        );
    });

    addCompanyModalBackdrop.addEventListener('click', (event) => {
        if (event.target === addCompanyModalBackdrop) {
            closeAddCompanyModal();
        }
    });

    const __csrf = '{{ csrf_token() }}';

    function showCompanyDeleteLoader(cb) {
        const el = document.getElementById('companyDeleteLoader');
        if (!el) return cb();
        el.classList.remove('hidden');
        setTimeout(() => cb(), 75);
    }

    function deleteCompany(id) {
        openConfirm({
            title: 'Delete Company',
            message: 'This will permanently delete the company and its data. Continue?',
            confirmText: 'Delete',
            variant: 'danger',
            onConfirm: () => {
                showCompanyDeleteLoader(() => {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ url('companies') }}/' + id;
                    form.style.display = 'none';

                    const csrf = document.createElement('input');
                    csrf.name = '_token';
                    csrf.value = __csrf;
                    form.appendChild(csrf);

                    const method = document.createElement('input');
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                });
            }
        });
    }

    @if ($errors->any())
        openAddCompanyModal();
    @endif
</script>
