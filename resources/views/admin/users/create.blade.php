@extends('adminr.layouts.master')

@section('title', __('Create new user'))

@push('scopedCss')
    <style>
        .lq-user-avatar-selector {
            position: relative;
            height: 100px;
            width: 100px;
            border-radius: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            object-fit: cover;
            border: 2px dashed #9b9b9b;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid" id="app">
        <div class="d-sm-flex justify-content-between align-items-center mb-3">
            <h3 class="text-dark mb-0">{{ __('Add new user') }}</h3>
            <div>
                <a href="{{ route(config('app.route_prefix').'.users.index') }}"
                   class="btn btn-primary btn-sm d-none d-sm-inline-block">
                    <svg class="c-icon mr-1">
                        <use xlink:href="{{ coreUiIcon('cil-user') }}"></use>
                    </svg>
                    {{ __('View all users') }}
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route(config('app.route_prefix').'.users.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <p class="card-title m-0">{{ __('Add new User') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }} <span
                                                            class="text-danger">*</span></label>
                                                <input type="text"
                                                       class="form-control @if($errors->has('name')) is-invalid @endif"
                                                       name="name" id="name" placeholder="{{ __('Name') }}"
                                                       value="{{ old('name') }}" required>
                                                @if($errors->has('name'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="username">{{ __('Username') }} <span
                                                            class="text-danger">*</span></label>
                                                <input type="text"
                                                       class="form-control @if($errors->has('username')) is-invalid @endif"
                                                       name="username" id="username" placeholder="{{ __('Username') }}"
                                                       value="{{ old('username') }}" required>
                                                @if($errors->has('username'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('username') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">{{ __('Email') }} <span class="text-danger">*</span></label>
                                                <input type="text"
                                                       class="form-control @if($errors->has('email')) is-invalid @endif"
                                                       name="email" id="email" placeholder="{{ __('Email address') }}"
                                                       value="{{ old('email') }}" required>
                                                @if($errors->has('email'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="phone">{{ __('Phone') }} <span class="text-danger">*</span></label>
                                                <input type="text"
                                                       class="form-control @if($errors->has('phone')) is-invalid @endif"
                                                       name="phone" id="phone" placeholder="{{ __('Contact No.') }}"
                                                       value="{{ old('phone') }}" required>
                                                @if($errors->has('phone'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('phone') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="password">{{ __('Password') }} <span
                                                            class="text-danger">*</span></label>
                                                <input type="password"
                                                       class="form-control @if($errors->has('password')) is-invalid @endif"
                                                       name="password" id="password" placeholder="{{ __('Password') }}"
                                                       required>
                                                @if($errors->has('password'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="confirm_password">{{ __('Confirm Password') }} <span
                                                            class="text-danger">*</span></label>
                                                <input type="password"
                                                       class="form-control @if($errors->has('confirm_password')) is-invalid @endif"
                                                       name="confirm_password" id="confirm_password"
                                                       placeholder="{{ __('Confirm  Password') }}" required>
                                                @if($errors->has('confirm_password'))
                                                    <span class="text-danger font-weight-bold">{{ $errors->first('confirm_password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="role">{{ __('Role') }} <span
                                                    class="text-danger">*</span></label>
                                        <select class="form-control select2 @if($errors->has('role')) is-invalid @endif"
                                                name="role" id="role" required>
                                            <option value="">--Select Role--</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ \Illuminate\Support\Str::replace('_', ' ', \Illuminate\Support\Str::title($role->name)) }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('role'))
                                            <span class="text-danger font-weight-bold">{{ $errors->first('role') }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-4 text-center">
                                        <label class="lq-user-avatar-selector mx-auto">
                                            <span class="position-absolute rounded-circle d-none lq-overlay"></span>
                                            <input type="file" class="d-none" name="avatar" id="avatar"
                                                   accept="image/*">
                                            <span class="ml-2 mb-2">
                                            <svg class="mr-1 text-muted" style="height: 25px;">
                                                <use xlink:href="{{ coreUiIcon('cil-user-plus') }}"></use>
                                            </svg>
                                        </span>
                                        </label>
                                        <label for="avatar" class="btn btn-default">{{ __('Select avatar') }}</label>
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
    <script>

        $(document).on('change', '#avatar', function (e) {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.lq-user-avatar-selector .lq-overlay').removeClass('d-none');
                    $('.lq-user-avatar-selector svg').removeClass('text-muted').addClass('text-white');
                    $('.lq-user-avatar-selector').css('background-image', 'url("' + e.target.result + '")');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
