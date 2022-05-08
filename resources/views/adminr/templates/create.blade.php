@extends('adminr.layouts.master')

@section('title', __('Create new template'))

@push('scopedCss')
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
@endpush

@section('content')
    <div class="container-fluid" id="app">
        <div class="d-sm-flex justify-content-between align-items-center mb-3">
            <h3 class="text-dark mb-0">{{ __('Add new template') }}</h3>
            <div>
                <a href="{{ route(config('app.route_prefix').'.templates.index') }}"
                   class="btn btn-primary btn-sm d-none d-sm-inline-block">
                    <x-cicon name="list" class="c-icon mr-1" />
                    {{ __('View all templates') }}
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route(config('app.route_prefix').'.templates.store') }}" method="POST"
                          enctype="multipart/form-data" id="template-form">
                        <div class="card-header">
                            <p class="card-title m-0">{{ __('Add new mail template') }}</p>
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
                                                       name="subject" id="subject" placeholder="{{ __('Eg: Order placed successfully!') }}"
                                                       value="{{ old('subject') }}" required>
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
                                                       name="code" id="code" placeholder="{{ __('Eg: order-placed-mail') }}"
                                                       value="{{ old('code') }}" required>
                                                @if($errors->has('code'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('code') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="subject">{{ __('Purpose') }}</label>
                                                <input type="text"
                                                       class="form-control @if($errors->has('purpose')) is-invalid @endif"
                                                       name="purpose" id="purpose" placeholder="{{ __('Eg: To be sent when order placed.') }}"
                                                       value="{{ old('purpose') }}">
                                                @if($errors->has('purpose'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('purpose') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="content">{{ __('Content') }} <span
                                                        class="text-danger">*</span></label>
                                                <textarea rows="8"
                                                          class="form-control @if($errors->has('content')) is-invalid @endif"
                                                          id="content"
                                                >{{ old('content') }}</textarea>
                                                @if($errors->has('content'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('content') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    @include('adminr.templates.partials.information')
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">
                                <x-cicon name="save" class="c-icon mr-1" />
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
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <script>
        $(document).on('input', '#subject', function (e) {
            var subject = $(this).val();
            $('#code').val(subject.split(" ").map(function (e) {
                return e.toLowerCase();
            }).join('-'));
        });
        const easyMDE = new EasyMDE({element: document.getElementById('content')});
        // easyMDE.value();

        $('#template-form').on('submit', function (e) {
            e.preventDefault();
            $('button[type="submit"]').attr('disabled', true);
            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: {
                    "subject": $('#subject').val(),
                    "purpose": $('#purpose').val(),
                    "code": $('#code').val(),
                    "content": easyMDE.value(),
                },
                success: function (res) {
                    toastr.success(res.message);
                    $('#subject').val('');
                    $('#code').val('');
                    easyMDE.value('');
                    setTimeout(function () {
                        $('button[type="submit"]').removeAttribute('disabled');
                        window.location.href = "{{ route(config('app.route_prefix').'.templates.index') }}";
                    }, 2000);
                },
            });

        })


    </script>
@endpush
