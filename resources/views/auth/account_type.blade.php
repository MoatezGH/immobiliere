@extends('layouts.app')


@section('content')
    @push('stylesheets')
        <style>
            .btn-p {
                border: 1px solid #004aad;
                color: #004aad !important;
                /* Adjust this value as needed */
            }

            .btn-p:hover {
                border: 1px solid #004aad;
                color: white !important;
                background-color: #004aad !important;
                /* Adjust this value as needed */
            }

            .btn-deb {
                border: 1px solid #03ba18;
                color: #03ba18 !important;
            }

            .btn-deb:hover {
                border: 1px solid #03ba18;
                color: white !important;
                background-color: #03ba18 !important;
            }





            .social-login a i {
                margin-right: 5px;
            }
        </style>
    @endpush
    <!-- breadcrumb -->
    <!-- <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
        <div class="container">
            <h2 class="breadcrumb-title">Type de compte</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Accueil</a></li>
                <li class="active">Type de compte</li>
            </ul>
        </div>
    </div> -->

    @include("includes.image_page")


    <!-- login area -->
    <div class="login-area py-120">
        <div class="container">
            <div class="col-md-5 mx-auto">
                <div class="login-form">
                    <div class="login-header">
                        <img src="assets/img/logo/logo-dark.png" alt="">
                        <p>Choisissez votre type de compte</p>
                    </div>
                    <center>
                        <div class="col-md-8">
                            <div class="social-login">
                                <a href="{{ route('get_register_immo') }}" class="btn-fb">
                                    <i class="fa fa-house"></i>
                                    ANNONCEUR IMMOBILIER</a>
                                <a href="{{ route('service_user.register_form') }}" class="btn-gl">
                                    <i class="fa fa-hand"></i>
                                    ANNONCEUR SERVICES</a>
                                
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- login area end -->
@endsection
