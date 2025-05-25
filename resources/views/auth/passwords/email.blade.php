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
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        @if (session('status'))
                            <div class="alert
                        alert-success" role="alert">
                                {{ session('status') }}
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
                        <div class="d-flex align-items-center">
                            <button type="submit" class="theme-btn"><i class="far fa-sign-in"></i>
                                Envoyer</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- login area end -->
@endsection
