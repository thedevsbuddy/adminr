@extends('adminr::layouts.master')

@section('title', __('Email Settings'))

@push('scopedCss')

@endpush

@section('content')
	<div class="container-fluid" id="app">
		<div class="d-sm-flex justify-content-between align-items-center mb-3">
			<h3 class="text-dark mb-0">{{ __('Manage Email Settings') }}</h3>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header d-flex justify-content-between align-items-center">
						<p class="card-title m-0">{{ __('Email Settings') }}</p>
						<button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
						        data-target="#sendTestMailModal">
							Send test mail
						</button>
					</div>
					<div class="card-body">
						@if(config('adminr.app_mode') == 'dev')
							<div class="alert alert-info">
								You can use the <a href="https://mailtrap.io" style="text-decoration: underline"
								                   target="_blank">mailtrap.io
									<x-cicon name="external-link" style="width: 10px"/>
								</a> service for testing emails
							</div>
						@endif
						<form action="{{ route('adminr.settings.store') }}" method="POST"
						      enctype="multipart/form-data">
							@csrf
							<div class="pr-4">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="mail_from_name">Mail from name <span class="text-danger">*</span></label>
											<input type="text"
											       class="form-control @if($errors->has('mail_from_name')) is-invalid @endif"
											       name="mail_from_name" id="mail_from_name"
											       placeholder="Mail from name"
											       value="{{ old('mail_from_name') ?? getSetting('mail_from_name') }}"
											       required>
											@if($errors->has('mail_from_name'))
												<span class="text-danger">{{ $errors->first('mail_from_name') }}</span>
											@endif
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="mail_from_email">Mail from email <span class="text-danger">*</span></label>
											<input type="text"
											       class="form-control @if($errors->has('mail_from_email')) is-invalid @endif"
											       name="mail_from_email" id="mail_from_email"
											       placeholder="Mail from email"
											       value="{{ old('mail_from_email') ?? getSetting('mail_from_email') }}"
											       required>
											@if($errors->has('mail_from_email'))
												<span class="text-danger">{{ $errors->first('mail_from_email') }}</span>
											@endif
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="mail_driver">Mail Driver <span class="text-danger">*</span> <i class="mdi mdi-help-circle" data-toggle="tooltip" title="Please select SMTP for local and SENDGRID for production if you want to use SENDGRID Driver."></i></label>
											<select name="mail_driver" id="mail_driver" class="form-control select2" required>
												<option value="smtp" @if(getSetting('mail_driver') == 'smtp') selected @endif>SMTP
												</option>
												<option value="sendmail" @if(getSetting('mail_driver') == 'sendmail') selected @endif>
													SendGrid
												</option>
											</select>

											@if($errors->has('mail_driver'))
												<span class="text-danger">{{ $errors->first('mail_driver') }}</span>
											@endif
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="mail_encryption">Mail Encryption <span class="text-danger">*</span></label>
											<select
													class="form-control select2 @if($errors->has('mail_encryption')) is-invalid @endif"
													name="mail_encryption" id="mail_encryption">
												<option value="ssl"
												        @if(getSetting('mail_encryption') == 'ssl') selected @endif>SSL
												</option>
												<option value="tls"
												        @if(getSetting('mail_encryption') == 'tls') selected @endif>TLS
												</option>
											</select>
											@if($errors->has('mail_encryption'))
												<span class="text-danger">{{ $errors->first('mail_encryption') }}</span>
											@endif
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="mail_host">Mail Host <span class="text-danger">*</span></label>
											<input type="text"
											       class="form-control @if($errors->has('mail_host')) is-invalid @endif"
											       name="mail_host" id="mail_host"
											       placeholder="Mail Host"
											       value="{{ old('mail_host') ?? getSetting('mail_host') }}">
											@if($errors->has('mail_host'))
												<span class="text-danger">{{ $errors->first('mail_host') }}</span>
											@endif
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="mail_port">Mail Port <span class="text-danger">*</span></label>
											<input type="text"
											       class="form-control @if($errors->has('mail_port')) is-invalid @endif"
											       name="mail_port" id="mail_port"
											       placeholder="Mail Port"
											       value="{{ old('mail_port') ?? getSetting('mail_port') }}">
											@if($errors->has('mail_port'))
												<span class="text-danger">{{ $errors->first('mail_port') }}</span>
											@endif
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="mail_username">Mail Username <span class="text-danger">*</span></label>
											<input type="text"
											       class="form-control @if($errors->has('mail_username')) is-invalid @endif"
											       name="mail_username" id="mail_username"
											       placeholder="Mail Username"
											       value="{{ old('mail_username') ?? getSetting('mail_username') }}">
											@if($errors->has('mail_username'))
												<span class="text-danger">{{ $errors->first('mail_username') }}</span>
											@endif
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="mail_password">Mail Password <span class="text-danger">*</span></label>
											<input type="password"
											       class="form-control @if($errors->has('mail_password')) is-invalid @endif"
											       name="mail_password" id="mail_password"
											       placeholder="Mail Password"
											       value="{{ old('mail_password') ?? getSetting('mail_password') }}">
											@if($errors->has('mail_password'))
												<span class="text-danger">{{ $errors->first('mail_password') }}</span>
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



	<!-- Modal -->
	<div class="modal fade" id="sendTestMailModal" tabindex="-1" aria-labelledby="sendTestMailModalLabel"
	     aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form action="{{ route('adminr.test-mail') }}" method="POST">
					@csrf
					<div class="modal-header">
						<h5 class="modal-title" id="sendTestMailModalLabel">Send Test Mail</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="email">Email <span class="text-danger">*</span></label>
							<input type="email" id="email" name="email" class="form-control"
							       placeholder="Recipient's email address.">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Send mail</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('scopedJs')
	<script>
		$(document).on('change', '#mail_driver', function () {
			if($(this).val() === 'sendmail'){
			    $('#mail_username').val('apikey').addClass('disabled').attr('disabled', true);
			} else {
			    $('#mail_username').removeClass('disabled').removeAttr('disabled');
			}
        });
	</script>
@endpush
