@extends('adminr.layouts.master')

@section('title', __('General Settings'))

@push('scopedCss')

@endpush

@section('content')
    <div class="container-fluid" id="app">
        <div class="d-sm-flex justify-content-between align-items-center mb-3">
            <h3 class="text-dark mb-0">{{ __('Manage General Settings') }}</h3>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title m-0">{{ __('General Settings') }}</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route(config('adminr.route_prefix').'.settings.store') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="app_name">App Name</label>
                                        <input type="text" class="form-control @if($errors->has('app_name')) is-invalid @endif"
                                               name="app_name" id="app_name" placeholder="App name"
                                               value="{{ old('app_name') ?? getSetting('app_name') }}" required>
                                        @if($errors->has('app_name'))
                                            <span class="text-danger">{{ $errors->first('app_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="app_tagline">App Tag Line</label>
                                        <input type="text" class="form-control @if($errors->has('app_tagline')) is-invalid @endif"
                                               name="app_tagline" id="app_tagline"
                                               placeholder="App Tag Line" value="{{ old('app_tagline') ?? getSetting('app_tagline') }}">
                                        @if($errors->has('app_tagline'))
                                            <span class="text-danger">{{ $errors->first('app_tagline') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_title">App meta title</label>
                                        <input type="text" class="form-control @if($errors->has('meta_title')) is-invalid @endif"
                                               name="meta_title" id="meta_title"
                                               placeholder="App meta title" value="{{ old('meta_title') ?? getSetting('meta_title') }}">
                                        @if($errors->has('meta_title'))
                                            <span class="text-danger">{{ $errors->first('meta_title') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">App meta description</label>
                                        <textarea rows="4" class="form-control @if($errors->has('meta_description')) is-invalid @endif"
                                                  name="meta_description" id="meta_description"
                                                  placeholder="App meta description"
                                                  style="resize: none">{{ old('meta_description') ?? getSetting('meta_description') }}</textarea>
                                        @if($errors->has('meta_description'))
                                            <span class="text-danger">{{ $errors->first('meta_description') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="title_separator">Title Separator</label>
                                        <select class="form-control select2 @if($errors->has('title_separator')) is-invalid @endif"
                                                name="title_separator" id="title_separator">
                                            <option value="-">Hyphen (-)</option>
                                            <option value="|">Pipe Sign (|)</option>
                                            <option value="~">Tilda (~)</option>
                                        </select>
                                        @if($errors->has('title_separator'))
                                            <span class="text-danger">{{ $errors->first('meta_title') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-center py-3">
                                        <div class="mb-3 text-center">
                                            <label class="custom-file-button rounded-circle mx-auto"
                                                   style="--aspect-ratio: 1; width: 100px; background-image: url({{ asset(getSetting('app_logo')) }})">
                                                <div class="custom-file-content">
                                    <span class="text-dark">
                                        <x-cicon name="camera" class="text-dark w-100 file-input-icon"
                                                 style="height: 25px;"/>
                                    </span>
                                                    <input name="app_logo" class="file-input" id="app_logo" type="file"
                                                           accept=".png, .svg, .jpg, .jpeg, .webp"/>
                                                </div>
                                            </label>
                                            <label for="app_logo">Change app logo</label>
                                        </div>
                                    </div>

                                    <div class="text-center py-3">
                                        <div class="mb-3 text-center">
                                            <label class="custom-file-button rounded-circle mx-auto"
                                                   style="--aspect-ratio: 1; width: 100px; background-image: url({{ asset(getSetting('app_logo')) }})">
                                                <div class="custom-file-content">
                                    <span class="text-dark">
                                        <x-cicon name="camera" class="text-dark w-100 file-input-icon"
                                                 style="height: 25px;"/>
                                    </span>
                                                    <input name="app_favicon" class="file-input" id="app_favicon" type="file"
                                                           accept=".png, .ico, .jpg"/>
                                                </div>
                                            </label>
                                            <label for="app_favicon">Change app favicon</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scopedJs')
@endpush
