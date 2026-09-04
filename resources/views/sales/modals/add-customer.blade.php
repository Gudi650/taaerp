<div id="modalAddCustomer" class="hidden fixed inset-0 z-50 flex items-start justify-center pt-20 pb-10 overflow-y-auto bg-transparent">
    <div class="bg-white shadow-sm border-l-4 border-l-brand-600 w-full max-w-4xl mx-4">
        <div
            class="flex items-center justify-between px-6 py-4">
            <div>
                <h3 id="modalTitle" class="text-lg font-semibold text-brand-700 font-display">Add Customer</h3>
                <p id="modalSubtitle" class="text-xs text-slate-500 mt-1">Create a new customer record</p>
            </div>
            <button onclick="closeLocalModal('modalAddCustomer'); resetCustomerForm();"
                class="w-8 h-8 bg-brand-50 text-brand-700 hover:bg-brand-100" aria-label="Close"><svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>

        <form id="customerForm" action="{{ route('customers.store') }}" method="POST" onsubmit="return showCustomerCreateLoader(event)">
            @csrf
            <div id="methodField"></div>
            <div class="px-6 py-5 max-h-96 overflow-y-auto space-y-6">
                <!-- Section 1: Customer Identity -->
                <div>
                    <h4 class="text-sm font-semibold text-slate-700 mb-3">Customer Identity</h4>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-slate-600 font-medium">Customer Type</label>
                                <select id="customer_type" name="customer_type"
                                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                                    <option value="">-- Select --</option>
                                    <option value="Individual">Individual</option>
                                    <option value="Company">Company</option>
                                    <option value="Government">Government</option>
                                    <option value="NGO">NGO</option>
                                    <option value="School">School</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs text-slate-600 font-medium">Company</label>
                                <select id="customer_company" name="company_id"
                                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                                    <option value="">-- Select Sub-Company --</option>
                                    @if (isset($companies))
                                        @foreach ($companies as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 font-medium">Customer Name <span
                                    class="text-red-500">*</span></label>
                            <input id="customer_name" name="customer_name" type="text"
                                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                                placeholder="Full name or company name" required />
                        </div>
                    </div>
                </div>

                <!-- Section 2: Contact Information -->
                <div>
                    <h4 class="text-sm font-semibold text-slate-700 mb-3">Contact Information</h4>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-slate-600 font-medium">Phone Number <span
                                        class="text-red-500">*</span></label>
                                <input id="customer_phone" name="phone_number" type="tel"
                                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                                    placeholder="+255..." required />
                            </div>
                            <div>
                                <label class="block text-xs text-slate-600 font-medium">WhatsApp Number</label>
                                <input id="customer_whatsapp" name="whatsapp_number" type="tel"
                                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"
                                    placeholder="+255..." />
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 font-medium">Email Address</label>
                            <input id="customer_email" name="email" type="email"
                                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" />
                        </div>
                    </div>
                </div>

                <!-- Section 3: Location -->
                <div>
                    <h4 class="text-sm font-semibold text-slate-700 mb-3">Location</h4>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-slate-600 font-medium">Region</label>
                                <select id="customer_region" name="region"
                                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                                    <option value="">-- Select Region --</option>
                                    <option value="Dar es Salaam">Dar es Salaam</option>
                                    <option value="Arusha">Arusha</option>
                                    <option value="Dodoma">Dodoma</option>
                                    <option value="Mbeya">Mbeya</option>
                                    <option value="Kilimanjaro">Kilimanjaro</option>
                                    <option value="Morogoro">Morogoro</option>
                                    <option value="Iringa">Iringa</option>
                                    <option value="Mwanza">Mwanza</option>
                                    <option value="Kagera">Kagera</option>
                                    <option value="Tanga">Tanga</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs text-slate-600 font-medium">District</label>
                                <input id="customer_district" name="district" type="text"
                                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 font-medium">Street Address</label>
                            <input id="customer_address" name="street_address" type="text"
                                class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" />
                        </div>
                    </div>
                </div>

                <!-- Section 4: Sales Information -->
                <div>
                    <h4 class="text-sm font-semibold text-slate-700 mb-3">Sales Information</h4>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <!--
                            <div>
                                <label class="block text-xs text-slate-600 font-medium">Assigned Sales Rep</label>
                                <select id="customer_sales_rep" class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                                    <option value="">-- Select Rep --</option>
                                    <option value="Samuel Lee">Samuel Lee</option>
                                    <option value="Marta Ruiz">Marta Ruiz</option>
                                    <option value="Daniel Okoro">Daniel Okoro</option>
                                </select>
                            </div>
                            -->
                            <div>
                                <label class="block text-xs text-slate-600 font-medium">Customer Source</label>
                                <select id="customer_source" name="customer_source"
                                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                                    <option value="">-- Select Source --</option>
                                    <option value="Walk In">Walk In</option>
                                    <option value="Referral">Referral</option>
                                    <option value="Social Media">Social Media</option>
                                    <option value="Phone Call">Phone Call</option>
                                    <option value="Website">Website</option>
                                    <option value="Exhibition">Exhibition</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">

                            <div>
                                <label class="block text-xs text-slate-600 font-medium">Price Category</label>
                                <select id="customer_price_category" name="price_category"
                                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                                    <option value="">-- Select --</option>
                                    <option value="Retail Price">Retail Price</option>
                                    <option value="Wholesale Price">Wholesale Price</option>
                                    <option value="Contract Price">Contract Price</option>
                                    <option value="Special Price">Special Price</option>
                                </select>
                            </div>

                            <!--
                            <div>
                                <label class="block text-xs text-slate-600 font-medium">Credit Limit (TZS)</label>
                                <input id="customer_credit_limit" type="number" class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" min="0" />
                            </div>
                            -->
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-slate-600 font-medium">Payment Terms</label>
                                <select id="customer_payment_terms" name="payment_terms"
                                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                                    <option value="">-- Select --</option>
                                    <option value="Cash">Cash</option>
                                    <option value="7 Days">7 Days</option>
                                    <option value="14 Days">14 Days</option>
                                    <option value="30 Days">30 Days</option>
                                    <option value="60 Days">60 Days</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs text-slate-600 font-medium">Preferred Payment
                                    Method</label>
                                <select id="customer_payment_method" name="preferred_payment_method"
                                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                                    <option value="">-- Select --</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Mobile Money M-Pesa">Mobile Money M-Pesa</option>
                                    <option value="Mobile Money Tigopesa">Mobile Money Tigopesa</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Additional Information -->
                <div>
                    <h4 class="text-sm font-semibold text-slate-700 mb-3">Additional Information</h4>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">

                            <div>
                                <label class="block text-xs text-slate-600 font-medium">Status</label>
                                <select id="customer_status" name="status"
                                    class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Prospect">Prospect</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 font-medium">Notes / Additional Info</label>
                            <textarea id="customer_notes" name="notes" class="mt-1 w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" rows="3"
                                placeholder="Any additional notes about this customer..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 flex gap-3 justify-end border-t border-slate-100 bg-slate-50">
                <button type="button" onclick="closeLocalModal('modalAddCustomer'); resetCustomerForm();"
                    class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
                <button type="submit" id="submitCustomerBtn"
                    class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Add Customer</button>
            </div>
        </form>
    </div>
</div>
