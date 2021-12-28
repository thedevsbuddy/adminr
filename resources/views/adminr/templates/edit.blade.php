@extends('adminr.layouts.master')

@section('title', __('Edit template'))

@push('scopedCss')
    <link rel="stylesheet" href="{{ asset('adminr/css/bs-md-editor.css') }}">
@endpush

@section('content')
    <div class="container-fluid" id="app">
        <div class="d-sm-flex justify-content-between align-items-center mb-3">
            <h3 class="text-dark mb-0">{{ __('Edit template') }}</h3>
            <div>
                <a href="{{ route(config('app.route_prefix').'.templates.index') }}"
                   class="btn btn-primary btn-sm d-none d-sm-inline-block">
                    <svg class="c-icon mr-1">
                        <use xlink:href="{{ coreUiIcon('cil-list') }}"></use>
                    </svg>
                    {{ __('View all templates') }}
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route(config('app.route_prefix').'.templates.update', $template->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card-header">
                            <p class="card-title m-0">{{ __('Edit mail template') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="subject">{{ __('Subject') }} <span
                                                            class="text-danger">*</span></label>
                                                <input type="text"
                                                       class="form-control @if($errors->has('subject')) is-invalid @endif"
                                                       name="subject" id="subject" placeholder="{{ __('Subject') }}"
                                                       value="{{ $template->subject ?? old('subject') }}" required>
                                                @if($errors->has('subject'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('subject') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="code">{{ __('Code') }} <span
                                                            class="text-danger">*</span></label>
                                                <input type="text"
                                                       class="form-control @if($errors->has('code')) is-invalid @endif"
                                                       name="code" id="code" placeholder="{{ __('Mail Code') }}"
                                                       value="{{ $template->code ?? old('code') }}" required>
                                                @if($errors->has('code'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('code') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="content">{{ __('Content') }} <span class="text-danger">*</span></label>
                                                <textarea rows="8"
                                                          class="form-control @if($errors->has('content')) is-invalid @endif"
                                                          name="content" id="content" placeholder="{{ __('Mail Content') }}"
                                                          required>{{ $template->content ?? old('content') }}</textarea>
                                                @if($errors->has('content'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('content') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h3>Important Information</h3>
                                    <div>
                                        <h5>Default Variables</h5>
                                        <ul>
                                            <li><code>{br}</code> or <code>{nl}</code>: For line break</li>
                                            <li><code>{app.name}</code>: For app name</li>
                                            <li><code>{app.url}</code>: For app root url</li>
                                        </ul>
                                        <h5>Styling mail template</h5>
                                        <p>We are allowing you to use <code>markdown</code> to style and compose your mail template.</p>
                                        <p><strong>Example:</strong></p>
                                        <p>You can use <code>markdown</code> as <code># this is the h1 heading</code> to create <code>h1</code> heading.</p>
                                        <p><strong>Note: Please note that you can use markdown only in the content section.</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">
                                <svg class="c-icon mr-1">
                                    <use xlink:href="{{ coreUiIcon('cil-save') }}"></use>
                                </svg>
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scopedJs')
    <script src="{{ asset('adminr/js/bs-md-editor.js') }}"></script>
    <script>

        $(function () {
            $('#content').markdownEditor();
        });

        $(document).on('input', '#subject', function (e) {
            var subject = $(this).val();
            $('#code').val(subject.split(" ").map(function (e) {
                return e.toLowerCase();
            }).join('-'));

        });

    </script>
@endpush
