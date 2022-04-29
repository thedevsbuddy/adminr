@extends('adminr.layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Login</h1>
                            <p class="text-muted">Sign In to your account</p>
                            <form method="POST" action="{{ route('auth.login') }}">
                                @csrf
                                <label for="email">Username or Email*</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ coreUiIcon('cil-user') }}"></use>
                                            </svg>
                                        </span>
                                    </div>
                                    <input id="email" type="text"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="off"
                                           placeholder="Username or email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="password">Password*</label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ coreUiIcon('cil-lock-locked') }}"></use>
                                            </svg>
                                        </span>
                                    </div>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           placeholder="Password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-primary px-4" type="submit">Login</button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="btn btn-link px-0" href="#">Forgot password?</a>
                                    </div>
                                </div>
                            </form>
                            <p class="text-center mt-3">OR</p>
                            <a href="{{ route('auth.register') }}" class="btn btn-block btn-light px-4">Create an
                                account</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
