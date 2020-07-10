@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="">
            <div class="login-wrapper wow animate__animated animate__fadeIn" data-wow-duration="1s" data-wow-delay="0.8s">

                <div class="login-content">
                    <h3 class="text-center my-3 wow animate__animated animate__fadeInUp" ata-wow-duration="1.2s" data-wow-delay="1s">
                        Welcome Back!
                    </h3>
                     @if ($errors->any())
                        <div class="">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                   


                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="">
                            <div class="col-md-12">
                                <input id="email" type="email" class=" @error('email') is-invalid @enderror wow animate__animated animate__fadeInUp" name="email" value="{{ old('email') }}" required placeholder="Email Address" autocomplete="email" autofocus  data-wow-duration="1.6s" data-wow-delay="1.2s">
                            </div>
                        </div>

                        <div class="">
                            <div class="col-md-12">
                                <input id="password" type="password" class=" @error('password') is-invalid @enderror wow animate__animated animate__fadeInUp" name="password" required autocomplete="current-password" placeholder="Password" data-wow-duration="1.8s" data-wow-delay="1.4s">
                            </div>
                        </div>

                        <div class="">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input wow animate__animated animate__fadeInUp" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} data-wow-duration="1.8s" data-wow-delay="1.6s">

                                    <label class="form-check-label wow animate__animated animate__fadeInUp" for="remember" data-wow-duration="1.8s" data-wow-delay="1.8s">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <div class="col-md-12">

                            @if (Route::has('password.request'))
                                    <a class="btn-block wow animate__animated animate__fadeInUp" href="{{ route('password.request') }}" data-wow-duration="1.8s" data-wow-delay="2s">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            
                                <button type="submit" class="btnfos btnfos-5 wow animate__animated animate__fadeInUp" data-wow-duration="1.8s" data-wow-delay="2.2s">
                                    {{ __('Account Login') }}
                                </button>

                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
