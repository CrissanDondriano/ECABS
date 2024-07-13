@extends('layouts.app')

@section('title', 'ECABS : Register Here')

@section('notes')
    <div class="position-absolute top-50 start-50 translate-middle p-3 shadow-lg rounded alert alert-danger alert-dismissible fade show">
        <h5 class="fw-bold pb-2">Important Instruction on Registration</h5>
        <ul class="list-unstyled text-dark">
            <li class="pb-3">Birthdate rules:
                <ul>
                    <li>Make sure you must be 18 years old and above</li>
                </ul>
            </li>
            <li>Password rules:
                <ul>
                    <li>At least 1 uppercase letter</li>
                    <li>At least 1 lowercase letter</li>
                    <li>At least 1 symbol</li>
                    <li>At least 1 number</li>
                    <li>Minimum of 8 characters</li>
                </ul>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="login-card card-body">
        <a href="/" class="d-flex align-items-center justify-content-center mb-1 p-3 text-dark text-decoration-none">
            <img class="" src="{!! url('assets/images/CABS.png') !!}" alt="" width="50" height="50">
            <span class="h4 fw-bold mt-2 px-1 logo-name text-danger">Cabuyao Athletes Basic School</span>
        </a>

        <h1 class="fw-bold logo-name text-muted p-2 text-center text-uppercase">Create an account</h1>

        <form method="REQUEST" action="{{ route('confirmation.show') }}" class="d-flex flex-column justify-content-center mx-5 px-3">
            @csrf

            <div class="mb-3">

                <input id="name" type="text" placeholder="Name"
                    class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
                    required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="mb-3">

                <input id="contact" type="contact" placeholder="Contact Number"
                    class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}"
                    required autocomplete="contact">

                @error('contact')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="mb-3">

                <div class="date-input-wrapper">
                    <input id="bday" type="date" class="form-control @error('bday') is-invalid @enderror"
                        name="bday" value="{{ old('bday') }}" required autocomplete="bday">

                    <label for="bday" class="input-placeholder">Select your birthdate</label>

                    @error('bday')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">

                <input id="address" type="address" placeholder="Address"
                    class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}"
                    required autocomplete="address" autofocus>

                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="mb-3">

                <input id="email" type="email" placeholder="Email Number"
                    class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                    required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class=" mb-3">

                <input id="password" type="password" placeholder="Password"
                    class="form-control @error('password') is-invalid @enderror" name="password" required
                    autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="mb-4">
                <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control"
                    name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="pb-3">
                <button type="submit" class="fw-bold btn btn-outline-dark px-5 w-100" data-toggle="tooltip"
                    title="Register">
                    {{ __('Register') }}
                </button>
            </div>

            <div class="text-center pb-3">
                @if (Route::has('login'))
                    <a class="btn-link" href="{{ route('login') }}" data-toggle="tooltip" title="Sign In">Already
                        registered?</a>
                @endif
            </div>
        </form>
    </div>
@endsection
