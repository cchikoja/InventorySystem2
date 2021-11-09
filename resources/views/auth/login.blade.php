@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-6">
            <div class="text-center mt-5 pt-2">
                <img src="{{asset('images/logo.png')}}" width="250px" alt="">
            </div>
            <div class="card" style="border: none">
                @if(session('message'))
                    <div class="alert alert-danger my-3 mx-5" style="text-align: center"> <span class="fa fa-lock"></span>{{session('message')}}</div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label col-form-label-sm text-md-right">{{ __('E-Mail') }} <span class="fa fa-user-circle"></span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label col-form-label-sm text-md-right">{{ __('Password') }} <span class="fa fa-lock"></span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary btn-block" style="font-size: 13px">
                                    {{ __('Login') }} <span class="fa fa-sign-in-alt"></span>
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}" style="font-size: 13px">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
