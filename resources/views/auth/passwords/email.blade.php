@extends('layouts.app')

@section('title', 'ECABS : Forgot Password')

@section('content')
    <div class="card-body">
        <a href="/" class="d-flex align-items-center justify-content-center mb-1 p-3 text-dark text-decoration-none">
            <img class="" src="{!! url('assets/images/CABS.png') !!}" alt="" width="50" height="50">
            <span class="h4 fw-bold mt-2 px-1 logo-name text-danger">Cabuyao Athletes Basic School</span>
        </a>

        <h1 class="fw-bold logo-name text-muted p-3 text-center text-uppercase">Reset Password</h1>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="d-flex flex-column justify-content-center mx-5 px-3">
            @csrf

            <div class="input-group mb-3">

                <span class="input-group-text" id="basic-addon1">@</span>

                <input id="email" type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="text-center">

                <button type="submit" class="btn btn-outline-dark">
                    {{ __('Send Password Reset Link') }}
                </button>

            </div>
        </form>
    </div>
@endsection
