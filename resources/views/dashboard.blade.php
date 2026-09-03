@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


@php
    $icon = [
        'building' => 'M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6',
        'people' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 20a8 8 0 0116 0',
        'doc' => 'M7 3h7l5 5v13H7V3zM14 3v5h5',
        'list' => 'M4 6h16M4 10h16M4 14h10M4 18h6',
        'cal' => 'M8 3v3M16 3v3M4 8h16M5 6h14a1 1 0 011 1v12a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1z',
        'box' => 'M21 16V8l-9-5-9 5v8l9 5 9-5zM3 8l9 5 9-5M12 13v8',
        'cart' => 'M4 6h2l2 10h10l2-7H8M8 21a1 1 0 100-2 1 1 0 000 2zM18 21a1 1 0 100-2 1 1 0 000 2z',
        'sign' => 'M14 3h7v7M21 3l-9 9M10 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-4',
    ];
    $activeCompanies = $companies->where('status', 'Active')->count();
    $maxHeadcount = max(1, (int) $companies->max('users_count'));
    $kpis = [
        ['Companies', $totalCompanies, $activeCompanies.' active', $icon['building']],
        ['Employees', $totalEmployees, 'in '.$totalCompanies.' compan'.((int) $totalCompanies === 1 ? 'y' : 'ies'), $icon['people']],
        ['Invoices', $totalInvoices, $pendingInvoices.' pending', $icon['doc']],
        ['Expenses', $totalExpenses, $pendingExpenses.' pending', $icon['list']],
    ];
    $attentionItems = array_values(array_filter([
        ['Invoice approvals', (int) ($pendingInvoices ?? 0), route('invoices.index'), $icon['doc']],
        ['Expense approvals', (int) ($pendingExpenses ?? 0), route('finance'), $icon['list']],
        ['Leave requests', (int) ($pendingLeaves ?? 0), route('hrm'), $icon['cal']],
        ['Low stock items', (int) ($lowStockItems ?? 0), route('inventory'), $icon['box']],
    ], fn ($i) => $i[1] > 0));
    usort($attentionItems, fn ($a, $b) => $b[1] <=> $a[1]);
    $attentionTotal = array_sum(array_column($attentionItems, 1));
    $actions = [
        ['invoices.index', 'Create invoice', $icon['doc'], true],
        ['finance', 'Record expense', $icon['list'], false],
        ['hrm', 'Review leaves', $icon['cal'], false],
        ['sales', 'New order', $icon['cart'], false],
        ['inventory', 'Add product', $icon['box'], false],
        ['sales', 'New contract', $icon['sign'], false],
    ];
@endphp

<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">
    @include('dashboard.money')
    @include('dashboard.kpis')
    @include('dashboard.review')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @include('dashboard.companies')
        <aside class="space-y-6">
            @include('dashboard.attention')
            @include('dashboard.actions')
            @include('dashboard.invoices')
        </aside>
    </div>
</main>
@endsection
