<div id="itemsPane" class="hidden">



    <div class="bg-white shadow-sm p-4 mb-4">
        <form class="flex gap-2 items-end">
            <div class="flex-1">
                <label class="block text-sm text-slate-600 mb-1">Category</label>
                <select class="w-full h-9 px-3 border border-slate-200 bg-white text-sm outline-none focus:border-brand-600">
                    <option>All categories</option>
                    @forelse ($itemsCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @empty
                        <option value="">No categories available</option>
                    @endforelse
                </select>
            </div>
            <button type="button" class="h-9 px-4 bg-brand-600 text-white text-sm font-medium hover:bg-brand-700">Apply</button>
        </form>
    </div>

    <div class="bg-white shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 text-brand-700 border-b-2 border-brand-600">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Item</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Category</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Notes</th>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 font-medium text-slate-800">{{ $item->item_name }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $item->category ? $item->category->category_name : 'No category' }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $item->description ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <div class="inline-flex gap-2">
                                <a class="h-8 px-3 bg-brand-50 text-brand-700 text-xs font-medium flex items-center">Edit</a>
                                <form method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="h-8 px-3 bg-red-50 text-red-600 text-xs font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-slate-500">No items found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
