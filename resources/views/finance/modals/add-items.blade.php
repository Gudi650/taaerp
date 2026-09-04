<!-- Item Creation -->
<div id="addItemsModal" class="hidden">
    <form action="{{ route('items.store') }}" method="POST" class="space-y-4"
        onsubmit="showItemsCreateLoader()">
        @csrf

        <div>
            <label class="block text-sm text-slate-600 mb-1">Item Name</label>
            <input name="item_name" type="text" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
        </div>

        <div>
            <label class="block text-sm text-slate-600 mb-1">Category</label>
            <select name="category_id" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option>Choose Category</option>

                @forelse ($itemsCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @empty
                    <option value="">No categories available</option>
                @endforelse

            </select>
        </div>

        <div>
            <label class="block text-sm text-slate-600 mb-1">Item Type</label>
            <select name="type" class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                <option value="general">Material</option>
                <option value="asset">Asset</option>
                <option value="liability">Liability</option>
            </select>
        </div>

        <div>
            <label class="block text-sm text-slate-600 mb-1">Notes</label>
            <textarea name="description" rows="2" class="w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600"></textarea>
        </div>

        <div class="flex gap-3 justify-end pt-2">
            <button type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Add Item</button>
        </div>
    </form>
</div>

<x-loading id="itemsCreateLoader" fullPage="true" class="hidden" />

<script>
    function showItemsCreateLoader() {
        const loader = document.getElementById('itemsCreateLoader');
        if (loader) {
            loader.classList.remove('hidden');
        }
    }
</script>
