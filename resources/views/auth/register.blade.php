@extends('layouts.app')

@section('auth')
<section class="register">
    <div class="imgBx">
        <div class="text-center">
            <h5>Start Organizing Your Tasks</h5>
            <h1>Join Us and Get Started</h1>
            <p>Enjoy the convenience of managing your tasks efficiently with our Dotlist app.</p>  
        </div>
        <img src="img/curved-images/curved11-small.jpg" alt="">
    </div>
    <div class="contentBx">
        <div class="formBx">
            <h2 class="text-center">{{ __('Sign Up') }}</h2>
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="inputBx">
                    <span>{{ __('Name') }}</span>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>                    
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="inputBx">
                    <span>{{ __('Email') }}</span>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="inputBx">
                    <span>{{ __('Password') }}</span>
                    <div class="input-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
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
                <div class="inputBx">
                    <span>{{ __('Confirm Password') }}</span>
                    <div class="input-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibilityConfirm()" id="password-toggle-confirm">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="inputBx">
                    <input type="submit" value="{{ __('Sign Up') }}" name="" id="">
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
                    <p>Already have an account? <a href="{{ route('login') }}" class="text-decoration-none link-primary">Log In</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection