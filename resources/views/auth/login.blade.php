@extends('layouts.app')

@section('title', 'ECABS : Login Here')

@section('content')

    <div class="login-card card-body">
        <a href="/" class="d-flex align-items-center justify-content-center mb-1 p-3 text-dark text-decoration-none">
            <img class="" src="{!! url('assets/images/CABS.png') !!}" alt="" width="50" height="50">
            <span class="h4 fw-bold mt-2 px-1 logo-name text-danger">Cabuyao Athletes Basic School</span>
        </a>

        <h1 class="fw-bold logo-name text-muted p-2 text-center text-uppercase">Sign in</h1>

        <form method="POST" action="{{ route('login') }}" class="d-flex flex-column justify-content-center mx-5 px-3">
            @csrf

            <div class="input-group mb-3">

                <span class="input-group-text" id="basic-addon1">@</span>

                <input id="email" type="email" placeholder="Email Address"
                    class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                    required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="input-group mb-4">
                <span class="input-group-text" id="basic-addon2">🔓︎</span>

                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="mb-4">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link " href="{{ route('password.request') }}" data-toggle="tooltip" title="Forgot Password">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="pb-3">
                <div class="col-md-12 ">
                    <button type="submit" class="fw-bold btn btn-outline-dark px-5 w-100" data-toggle="tooltip" title="Login">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>

            <div class="text-center pb-3">
                <div class="col-md-12">
                    @if (Route::has('register'))
                        <a class="btn-link" href="{{ route('register') }}" data-toggle="tooltip" title="Sign Up">Don't have an account?</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
