@if (!empty($pendingReviewCount ?? 0) && !empty($firstPendingReviewExpenseId))
    <div class="mb-6 bg-white shadow-sm border-l-4 border-l-red-600 px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <p class="text-sm font-semibold text-brand-700">Expense review needed</p>
            <p class="text-sm text-slate-500 mt-0.5">{{ $pendingReviewCount }} expense{{ $pendingReviewCount === 1 ? '' : 's' }} waiting for your feedback.</p>
        </div>
        <a href="{{ route('expenses.review', ['expense' => $firstPendingReviewExpenseId]) }}" class="inline-flex items-center justify-center h-9 px-4 bg-brand-600 text-white text-sm font-medium hover:bg-brand-700">Review now</a>
    </div>
@endif
