@extends('layouts.app')
<style>

    body{
        overflow: hidden;
    }
  
 
</style>
@section('content')
<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="{{ asset('img/sby/login.png') }}"
                        class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-outline mb-4">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" name="name"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required autocomplete="name" autofocus />
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-outline mb-4">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" name="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required autocomplete="email" autofocus />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-outline mb-4">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"
                                required autocomplete="new-password" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-outline mb-4">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control form-control-lg"
                                name="password_confirmation" required autocomplete="new-password" />
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('Register') }}</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
</body>
@endsection
