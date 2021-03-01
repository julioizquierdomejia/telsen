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
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="col-form-label">{{ __('Name') }}</label>

                            <div class="input-content">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>

                            <div class="input-content">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-form-label">{{ __('Password') }}</label>

                            <div class="input-content">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
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

                        <div class="form-group">
                            <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>

                            <div class="input-content">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <label class="icon password-toggle" for="password-confirm">
                                    <i class="fa fa-eye"></i>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-danger btn-orange btn-block">
                                    {{ __('Register') }}
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