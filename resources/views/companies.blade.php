@extends('layouts.app')

@section('title', 'Companies')

@section('content')
<main class="ml-0 lg:ml-64 pt-20 px-4 pb-6 lg:px-6 min-h-screen bg-slate-50">
    @include('companies.list')
</main>

@include('companies.modal')
@include('companies.scripts')
<x-loading id="companyDeleteLoader" message="Deleting company..." full-page="true" class="hidden" />
@endsection
