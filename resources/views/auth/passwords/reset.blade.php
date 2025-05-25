{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}



@extends('layouts.app')


@section('content')
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
        <div class="container">
            <h2 class="breadcrumb-title">Mot de passe oublié</h2>
            <ul class="breadcrumb-menu">
                <li><a href="index.html">Accueil</a></li>
                <li class="active">Mot de passe oublié</li>
            </ul>
        </div>
    </div>

    {{-- {{ dd(dd(session()->all())) }} --}}
    {{-- {{ dd(session()->all()) }} --}}

    <!-- login area -->
    <div class="login-area py-120">
        <div class="container">
            <div class="col-md-5 mx-auto">
                <div class="login-form">
                    <div class="login-header">
                        <img src="{{ asset('assets/img/logo/logo-dark.png') }}" alt="">
                        <p>Réinitialisez le mot de passe de votre compte
                        </p>
                    </div>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @if (session('status'))
                            <div class="alert
                        alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label> Adresse E-mail</label>

                           <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            <i class="far fa-envelope"></i>

                        </div>
                        @include('message_session.error_field_message', [
                            'fieldName' => 'email',
                        ])

                        <div class="form-group">
                            <label> Nouveau mot de passe</label>

                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            <i class="far fa-key"></i>

                        </div>
                        @include('message_session.error_field_message', [
                            'fieldName' => 'password',
                        ])

                        <div class="form-group">
                            <label> Confirmer mot de passe</label>

                            {{-- <div class="col-md-6"> --}}
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                                <i class="far fa-key"></i>

                            {{-- </div> --}}

                        </div>
                        @include('message_session.error_field_message', [
                            'fieldName' => 'password_confirmation',
                        ])
                        <div class="d-flex align-items-center">
                            <button type="submit" class="theme-btn"><i class="far fa-sign-in"></i>
                                Réinitialisation du mot de passe</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- login area end -->
@endsection

