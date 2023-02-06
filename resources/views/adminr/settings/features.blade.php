@extends('adminr::layouts.master')

@section('title', __('Features Settings'))

@push('scopedCss')

@endpush

@section('content')
    <div class="container-fluid" id="app">
        <div class="d-sm-flex justify-content-between align-items-center mb-3">
            <h3 class="text-dark mb-0">{{ __('Manage Features Settings') }}</h3>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title m-0">{{ __('Features Settings') }}</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('adminr.settings.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="pr-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email_verification_enabled">Email Verification</label>
                                            <select name="email_verification_enabled" id="email_verification_enabled" class="form-control select2">
                                                <option value="1" @if(getSetting('email_verification_enabled') == "1") selected @endif>Enabled</option>
                                                <option value="0" @if(getSetting('email_verification_enabled') == "0") selected @endif>Disabled</option>
                                            </select>
                                            @if($errors->has('email_verification_enabled'))
                                                <span class="text-danger">{{ $errors->first('email_verification_enabled') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mail_queue_enabled">Email Queues</label>
                                            <select name="mail_queue_enabled" id="mail_queue_enabled" class="form-control select2">
                                                <option value="1" @if(getSetting('mail_queue_enabled') == "1") selected @endif>Enabled</option>
                                                <option value="0" @if(getSetting('mail_queue_enabled') == "0") selected @endif>Disabled</option>
                                            </select>
                                            @if($errors->has('mail_queue_enabled'))
                                                <span class="text-danger">{{ $errors->first('mail_queue_enabled') }}</span>
                                            @endif
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
