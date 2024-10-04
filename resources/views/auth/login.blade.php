@extends('layouts.app')

@section('auth')
<section class="login">
    <div class="contentBx">
        <div class="formBx">
            <h2 class="text-center">{{ __('Log In') }}</h2>
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="inputBx">
                    <span>Email</span>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="inputBx">
                    <span>Password</span>
                    <div class="input-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()" id="password-toggle">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="remember my-2">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                </div>
                <div class="inputBx">
                    <input type="submit" value="{{ __('Log In') }}" name="" id="">
                </div>

                <div class="text-center text-muted d-flex align-items-center my-2">
                    <hr class="border-bottom w-50">
                    <span class="mx-2 flex-grow-1 px-2">OR</span>
                    <hr class="border-bottom w-50">
                </div>
                
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 pe-md-2 p-0 order-2 order-md-1">
                            <a href="#" id="account" class="btn btn-light d-flex align-items-center justify-content-center mb-2">
                                <img src="{{ asset('img/logo/facebook-logo.png') }}" alt="Facebook Logo" style="height: 20px; width: auto;" class="me-2">
                                <span>Facebook</span>
                            </a>
                        </div>
                        <div class="col-md-6 ps-md-2 p-0 order-1 order-md-2">
                            <a href="{{ route('google.auth') }}" id="account" class="btn btn-light d-flex align-items-center justify-content-center mb-2">
                                <img src="{{ asset('img/logo/google-logo.png') }}" alt="Google Logo" style="height: 20px; width: auto;" class="me-2">
                                <span>Google</span>
                            </a>
                        </div>
                    </div>
                </div>                
                
                <div class="inputBx">
                    <p>Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none link-primary">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>
    <div class="imgBx">
        <div class="text-center">
            <h5>Manage Your Tasks Effortlessly</h5>
            <h1>Welcome Back Friend</h1>
            <p>A powerful to-do list app for staying organized and boosting your productivity.</p>
        </div>
        <img src="img/curved-images/curved-11.jpg" alt="">
    </div>
</section>
@endsection