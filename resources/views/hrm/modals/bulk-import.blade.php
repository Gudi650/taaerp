<div id="bulkImportModal" class="hidden fixed inset-0 bg-transparent z-50 flex items-start justify-center pt-20 overflow-y-auto">
    <div class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-2xl mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold text-brand-700 font-display">Bulk import</h2>
                <p class="text-xs text-slate-500 mt-0.5">CSV: Name, Email, Phone, Department, Join Date</p>
            </div>
            <button type="button" onclick="closeBulkImportModal()" class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div id="importStep1" class="space-y-4">
            <div class="bg-brand-50 border border-dashed border-brand-200 p-6 text-center cursor-pointer" id="dragDropZone">
                <input type="file" id="csvFileInput" accept=".csv,.txt" class="hidden" onchange="handleFileSelect(event)">
                <p id="dragDropPrompt" class="text-sm text-slate-600">Drag CSV here or <span class="text-brand-600 font-medium">browse</span></p>
                <p id="selectedCsvFile" class="hidden text-sm text-brand-600 font-medium"></p>
            </div>
            <div id="importStatus" class="hidden border px-3 py-2 text-sm"></div>
            @if ($isQualifiedUser)
                <select id="bulkImportCompany" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" required>
                    <option value="">Select company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @selected((string) $activeCompanyId === (string) $company->id)>{{ $company->name }}</option>
                    @endforeach
                </select>
            @else
                <input type="hidden" id="bulkImportCompany" value="{{ auth()->user()?->company_id }}">
                <div class="w-full h-9 px-3 border border-slate-200 bg-brand-50 text-brand-700 text-sm flex items-center">{{ auth()->user()?->company?->name ?? 'No company assigned' }}</div>
            @endif
            <button type="button" id="previewBtn" onclick="previewImport()" disabled class="w-full h-9 bg-brand-600 hover:bg-brand-700 disabled:bg-slate-300 text-white text-sm font-medium">Preview & validate</button>
        </div>

        <div id="importStep2" class="hidden space-y-4">
            <div id="previewResults" class="space-y-3">
                <div id="validRowsPreview" class="hidden">
                    <h3 class="text-sm font-medium text-brand-700 mb-2">Valid rows (<span id="validCount">0</span>)</h3>
                    <div id="validRowsList" class="bg-brand-50 p-3 max-h-40 overflow-y-auto text-xs text-slate-600 space-y-1"></div>
                </div>
                <div id="errorRowsPreview" class="hidden">
                    <h3 class="text-sm font-medium text-brand-700 mb-2">Error rows (<span id="errorCount">0</span>)</h3>
                    <div id="errorRowsList" class="bg-red-50 p-3 max-h-40 overflow-y-auto text-xs text-red-600 space-y-1"></div>
                </div>
                <div id="previewMessage" class="text-sm text-brand-700 bg-brand-50 p-3"></div>
            </div>
            <div class="flex gap-3 justify-end pt-2">
                <button type="button" onclick="backToUpload()" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Back</button>
                <button type="button" id="confirmBtn" onclick="confirmImport()" disabled class="h-9 px-4 bg-brand-600 hover:bg-brand-700 disabled:bg-slate-300 text-white text-sm font-medium">Confirm import</button>
            </div>
        </div>

        <div id="importStep3" class="hidden text-center space-y-4">
            <div id="importResult" class="bg-brand-50 p-4 text-sm"></div>
            <button type="button" onclick="closeBulkImportModal()" class="w-full h-9 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Close</button>
        </div>

        <div class="flex gap-3 justify-end pt-4 mt-6">
            <button type="button" onclick="closeBulkImportModal()" class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
        </div>
        <x-loading id="importLoader" size="lg" color="amber" full-page="true" message="Processing..." :show="false" />
    </div>
</div>
