@extends('layouts.main')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            {{ \Artesaos\SEOTools\Facades\SEOTools::getTitle(true) }}
            <a class="btn btn-success btn-sm" href="{{ route('products.create') }}">Create New</a>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>

@endsection
@push('custom_js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
