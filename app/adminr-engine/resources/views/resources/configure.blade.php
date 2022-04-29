@extends('adminr.layouts.master')

@section('title', __('Configure') . ' ' . $resource->name)

@push('scopedCss')

@endpush

@section('content')
<div class="container-fluid" id="app">
    <div class="d-sm-flex justify-content-between align-items-center mb-3">
        <h3 class="text-dark mb-0">{{ __('Configure') }} {{ $resource->name }}</h3>
        <div>
            <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm d-none d-sm-inline-block">
                <svg class="c-icon mr-1">
                    <use xlink:href="{{ coreUiIcon('cil-apps') }}"></use>
                </svg>
                {{ __('View all resource') }}
            </a>
        </div>
    </div>
    <configure-resource routes="{{ json_encode($routes) }}" crudid="{{$resource->id}}"></configure-resource>
</div>
@endsection

@push('scopedJs')
@endpush
