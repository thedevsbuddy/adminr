@extends('adminr::layouts.master')

@section('title', __('Generate new Resource'))

@push('scopedCss')

@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-3">
        <h3 class="text-dark mb-0">{{ __('Generate Resource') }}</h3>
        <div>
            <a href="{{ route('adminr.resources.index') }}" class="btn btn-primary btn-sm d-none d-sm-inline-block">
                <svg class="c-icon mr-1">
                    <use xlink:href="{{ adminrIcon('cil-list') }}"></use>
                </svg>
                {{ __('View all resources') }}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="card-title m-0">{{ __('Build awesome resource') }}</p>
                    <div class="font-weight-bold">
                        <strong>Note:</strong> <code>id</code> field and <code>timestamps</code> field will be generated
                        by default!
                    </div>
                </div>
                <div class="card-body">
                    <create-resource :datatypes="{{ json_encode($dataTypes) }}"></create-resource>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scopedJs')

@endpush
