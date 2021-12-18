@extends('adminr.layouts.master')

@section('title', __('Application Settings'))

@push('scopedCss')

@endpush

@section('content')
    <div class="container-fluid" id="app">
        <div class="d-sm-flex justify-content-between align-items-center mb-3">
            <h3 class="text-dark mb-0">{{ __('Manage Application Settings') }}</h3>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title m-0">{{ __('Application Settings') }}</p>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                     aria-orientation="vertical">
                                    <a class="nav-link active" id="v-general-setting-tab" data-toggle="pill"
                                       href="#v-general-setting" role="tab" aria-controls="v-general-setting"
                                       aria-selected="true">General</a>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-general-setting" role="tabpanel"
                                         aria-labelledby="v-pills-general-tab">
                                        @include('admin.settings.includes.general')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scopedJs')
@endpush
