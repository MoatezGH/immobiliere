@extends('layouts.app')
@section('pageTitle')
    Register
@endsection

@section('content')
@include("includes.image_page")


    {{-- {{ dd(auth()->guard("service_user")->user()) }} --}}

    <!-- login area -->
    <div class="login-area py-120">
        
        <div class="container">
            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(Session::has('error-message'))
                    <p class="alert alert-info">{{ Session::get('error-message') }}</p>
                @endif
                {{-- @if(Session::has('error'))
                    <p class="alert alert-info">{{ Session::get('error') }}</p>
                @endif --}}
            <div class="col-md-5 mx-auto">
                <div class="login-form">
                    <div class="login-header">
                        <img src="{{ asset('assets/img/logo/logo-dark.png') }}" alt="">
                        <p>Créez votre compte service</p>
                    </div>
                    @if ($errors->has('register'))
                        <div class="alert alert-danger">
                            {{ $errors->first('register') }}
                        </div>
                    @endif
                    <form action="{{ route('service_user.register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label> Nom & Prénom</label>
                            <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror"
                                name="full_name" value="{{ old('full_name') }}" required autocomplete="full_name" autofocus
                                placeholder="Votre nom & prénon">
                            <i class="far fa-user"></i>
                        </div>
                        @if ($errors->has('full_name'))
                            <div class="alert alert-danger">
                                {{ $errors->first('full_name') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label> Adresse E-mail</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Votre E-mail">
                            <i class="far fa-envelope"></i>
                        </div>
                        @if ($errors->has('email'))
                            <div class="alert alert-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                placeholder="******">
                            <i class="far fa-lock"></i>
                        </div>
                        @if ($errors->has('password'))
                            <div class="alert alert-danger">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Confirmation mot de passe</label>
                            <input id="password_confirmation" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" required placeholder="******">
                            <i class="far fa-lock"></i>
                        </div>
                        

                        <div class="form-check form-group">
                            <input class="form-check-input" type="checkbox" value="" id="agree">
                            <label class="form-check-label" for="agree">
                                J'accept <a href="#">les conditions d'utilisation.</a>
                            </label>
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" class="theme-btn"><i class="far fa-sign-in"></i> Inscription</button>
                        </div>
                    </form>
                    <div class="login-footer">
                        
                        <p>Vous avez déjà un compte? <a href="{{ route('login') }}">Se connecter.</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @push('scripts')
        <script>
            $(document).ready(function() {
                $('#category').select2();
            });
        </script>
    @endpush --}}
    <!-- login area end -->
@endsection
