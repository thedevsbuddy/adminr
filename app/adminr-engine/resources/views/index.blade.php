@extends('adminr.layouts.master')

@section('title', 'Laravel CMS')

@push('scopedCss')

@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-3">
        <h3 class="text-dark mb-0">Dashboard</h3>
    </div>
    {{-- TODO: add dynamically generated widgets and charts here --}}
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="text-muted text-right mb-4">
                        <svg class="c-icon c-icon-2xl">
                            <use xlink:href="{{ coreUiIcon('cil-people') }}"></use>
                        </svg>
                    </div>
                    <div class="text-value-lg">87.500</div>
                    <small class="text-muted text-uppercase font-weight-bold">Visitors</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scopedJs')

@endpush