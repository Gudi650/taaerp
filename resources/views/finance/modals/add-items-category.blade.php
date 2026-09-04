<!-- Items Category Modal -->
<div id="addItemCategoryModal" class="hidden ">

    <form action="{{ route('items.categories.store') }}" method="POST" id="itemCategoryForm" class="space-y-4" onsubmit="showItemsCategoryCreateLoader()">
        @csrf
      <div>
        <label class="block text-sm font-medium text-slate-700">Category</label>
        <input type="text" name="category_name" class="mt-1 w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" placeholder="eg: Operationals,Investments, Financial " required>
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700">Description</label>
        <textarea name="description" class="mt-1 w-full px-3 py-2 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600" rows="3" placeholder="Enter description"></textarea>
      </div>

      
      <div class="flex justify-end gap-3 pt-4">
        <button type="button" onclick="closeModal()"
            class="h-9 px-4 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Cancel</button>
        <button type="submit" class="h-9 px-4 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium">Save</button>
      </div>
    </form>

</div>
<x-loading id="itemsCategoryCreateLoader" fullPage="true" class="hidden" />

<script>
    function showItemsCategoryCreateLoader() {
        const loader = document.getElementById('itemsCategoryCreateLoader');
        if (loader) {
            loader.classList.remove('hidden');
        }
    }
</script>