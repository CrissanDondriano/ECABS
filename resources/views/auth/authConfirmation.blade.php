@extends('layouts.app')

@section('title', 'ECABS : OTP Confirmation')

@section('notes')
    <div class="position-absolute top-50 start-50 translate-middle p-3 shadow-lg rounded alert alert-danger alert-dismissible fade show">
        <h5 class="fw-bold pb-2">Important Instruction on Registration</h5>
        <ul class="list-unstyled text-dark">
            <li class="pb-3">Birthdate rules:
                <ul>
                    <li>Make sure you must be 18 years old and above</li>
                </ul>
            </li>
            <li>
                <ul>
                    <li>Name: {{ $name }}</li>
                    <li>Contact: {{ $contact }}</li>
                    <li>OTP Code: {{ $otpCode }}</li>
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

        <h1 class="fw-bold logo-name text-muted p-2 text-center text-uppercase">Confirm OTP Code</h1>

        <form method="POST" action="{{ route('register') }}" class="d-flex flex-column justify-content-center mx-5 px-3">
            @csrf

            <div class="mb-3">
                <input id="otp" type="text" placeholder="OTP Code"
                    class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}"
                    required autocomplete="otp" autofocus>
        
                @error('otp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- CHEATZ --}}
            <input type="hidden" id="name" name="name" value="{{$name}}">
            <input type="hidden" id="contact" name="contact" value="{{$contact}}">
            <input type="hidden" id="bday" name="bday" value="{{$bday}}">
            <input type="hidden" id="address" name="address" value="{{$address}}">
            <input type="hidden" id="email" name="email" value="{{$email}}">
            <input type="hidden" id="password" name="password" value="{{$password}}">
            <input type="hidden" id="password_confirmation" name="password_confirmation" value="{{$password_confirmation}}">
            {{-- CHEATZ --}}
            
            <div class="pb-3">
                <button type="submit" class="fw-bold btn btn-outline-dark px-5 w-100" data-toggle="tooltip"
                    title="Confirm Register">
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

