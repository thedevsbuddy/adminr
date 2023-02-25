@extends('layouts.auth')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-7">
				<div class="card-group">
					<div class="card p-4">
						<div class="card-body">
							<h1>Register</h1>
							<p class="text-muted">Create a new account</p>
							<form method="POST" action="{{ route('auth.register') }}">
								@csrf
								<div class="row">
									<div class="col-lg-6">
										<label for="name">Name <span class="text-danger">*</span></label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ adminrIcon('cil-user') }}"></use>
                                            </svg>
                                        </span>
											</div>
											<input id="name" type="text"
											       class="form-control @error('name') is-invalid @enderror" name="name"
											       value="{{ old('name') }}" required autocomplete="off"
											       placeholder="Name" autofocus>
											@error('name')
											<span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
											@enderror
										</div>
									</div>
									<div class="col-lg-6">
										<label for="username">Username <span class="text-danger">*</span></label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ adminrIcon('cil-user') }}"></use>
                                            </svg>
                                        </span>
											</div>
											<input id="username" type="text"
											       class="form-control @error('username') is-invalid @enderror"
											       name="username" value="{{ old('username') }}" required
											       autocomplete="off" placeholder="Username" autofocus>
											@error('username')
											<span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
											@enderror
										</div>
									</div>
									<div class="col-lg-6">
										<label for="email">Email <span class="text-danger">*</span></label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ adminrIcon('cil-send') }}"></use>
                                            </svg>
                                        </span>
											</div>
											<input id="email" type="text"
											       class="form-control @error('email') is-invalid @enderror"
											       name="email" value="{{ old('email') }}" required autocomplete="off"
											       placeholder="Email" autofocus>
											@error('email')
											<span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
											@enderror
										</div>
									</div>
									<div class="col-lg-6">
										<label for="phone">Phone <span class="text-danger">*</span></label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ adminrIcon('cil-phone') }}"></use>
                                            </svg>
                                        </span>
											</div>
											<input id="phone" type="text"
											       class="form-control @error('phone') is-invalid @enderror"
											       name="phone" value="{{ old('phone') }}" required autocomplete="off"
											       placeholder="Phone" autofocus>
											@error('phone')
											<span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12">
										<label for="password">Password*</label>
										<div class="input-group mb-4">
											<div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ adminrIcon('cil-lock-locked') }}"></use>
                                            </svg>
                                        </span>
											</div>
											<input id="password" type="password"
											       class="form-control @error('password') is-invalid @enderror"
											       name="password" placeholder="Password" required
											       autocomplete="current-password">
											@error('password')
											<span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
											@enderror
										</div>
									</div>
								</div>


								<div class="row">
									<div class="col-6">
										<button class="btn btn-block btn-primary px-4" type="submit">Register</button>
									</div>
									<div class="col-6">
										<a href="{{ route('auth.login') }}" class="btn btn-block btn-light px-4">Login here</a>
									</div>
								</div>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
