<div id="modalBackdrop" class="hidden fixed inset-0 bg-transparent z-50 flex items-start justify-center pt-20 overflow-y-auto">
  <div id="modalCard" class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-lg mx-4 p-6 max-h-[calc(100vh-5rem)] flex flex-col">
    <div class="flex items-center justify-between mb-4">
      <h2 id="modalTitle" class="text-lg font-semibold text-brand-700 font-display"></h2>
      <button onclick="closeModal()" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close">
        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <!-- Body -->
    <div id="modal-body" class="mt-4 overflow-y-auto flex-1 pr-1"></div>

    <!-- Footer -->
    <div id="modalFooter" class="flex gap-3 justify-end mt-6">
      <button onclick="closeModal()" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">
        Cancel
      </button>
      <button onclick="submitModal()" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">
        Submit
      </button>
    </div>
  </div>
</div>

<script>
  let modalCallback = null;

  window.openModal = function(title, bodyHTML, submitCallback = null, options = {}) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modal-body').innerHTML = bodyHTML;

    const modalCard = document.getElementById('modalCard');
    modalCard.className = 'bg-white shadow-sm border-l-4 border-l-brand-600 w-full mx-4 p-6 max-h-[calc(100vh-5rem)] flex flex-col ' + (options.widthClass || 'max-w-lg');

    const modalBody = document.getElementById('modal-body');
    modalBody.className = 'mt-4 overflow-y-auto flex-1 pr-1 ' + (options.bodyClass || '');

    const modalFooter = document.getElementById('modalFooter');
    modalFooter.classList.toggle('hidden', !!options.hideFooter);

    document.getElementById('modalBackdrop').classList.remove('hidden');
    modalCallback = submitCallback;
    window._modalOptions = options;
  };

  window.closeModal = function() {
    document.getElementById('modalBackdrop').classList.add('hidden');
    document.getElementById('modal-body').innerHTML = '';
    document.getElementById('modalFooter').classList.remove('hidden');
    modalCallback = null;
    window._modalOptions = null;
  };

  window.submitModal = async function() {
    if (modalCallback) {
      const shouldClose = await modalCallback();
      if (shouldClose === false) {
        return;
      }
    }
    closeModal();
  };

  // Close modal on backdrop click
  document.getElementById('modalBackdrop').addEventListener('click', function(e) {
    if (e.target === this) {
      closeModal();
    }
  });
</script>
