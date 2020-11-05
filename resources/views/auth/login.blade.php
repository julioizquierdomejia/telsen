@extends('layouts.login', ['body_class' => 'page_login page_centered'])
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-7 col-md-5 col-xl-4">
            <div class="card form-card">
                <div class="card-header text-center">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/images/logo-telsen.png" width="200">
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>
                                <div class="input-content">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <label class="icon" for="email">
                                        <i class="fa fa-envelope-o"></i>
                                    </label>
                                </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password" class="col-form-label">{{ __('Password') }}</label>
                                <div class="input-content">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <label class="icon password-toggle" for="password">
                                        <i class="fa fa-eye"></i>
                                    </label>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-danger btn-orange btn-block">
                                {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                        <div class="form-group row text-center">
                            <!-- <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="card-footer bg-white pb-0 text-muted text-center">
                        ¿No tienes una cuenta? <a class="btn-link text-orange" href="{{ route('register') }}"><u>Regístrate</u></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
    $('.password-toggle').click(function () {
        var $this = $(this), password = $this.parent().find('input');
        if (password.attr('type') == 'password') {
            password.attr('type', 'text');
            $this.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            password.attr('type', 'password');
            $this.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    })
</script>
@endsection