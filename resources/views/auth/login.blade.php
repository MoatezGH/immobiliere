@extends('layouts.app')
@section('pageTitle')
Se Connecter
@endsection

@section('content')
    @include("includes.image_page")
    <!-- login area -->
    <div class="login-area py-120">
        <div class="container">
            <div class="col-md-5 mx-auto">
                <div class="login-form">
                    <div class="login-header">
                        <img src="{{ asset('assets/img/logo/logo-dark.png') }}" alt="">
                        <p>Connectez-vous</p>
                    </div>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        @if (Session::get('fail'))
                            <div class="alert alert-danger">
                                {{ Session::get('fail') }}

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="form-group">

                            <label> Adresse E-mail</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <i class="far fa-envelope"></i>



                        </div>
                        @include('message_session.error_field_message', [
                            'fieldName' => 'email',
                        ])
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                            <i class="far fa-lock"></i>
                        </div>
                        @include('message_session.error_field_message', [
                            'fieldName' => 'password',
                        ])
                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                
                            </div>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-pass">Mot de passe oublié?</a>
                            @endif
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="submit" class="theme-btn"><i class="far fa-sign-in"></i> Se connecter</button>
                        </div>
                    </form>
                    <div class="login-footer">
                        
                        <p>Vous n'avez pas de compte ? <a href="{{ route('account_type') }}">S'inscrire.</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login area end -->
@endsection
