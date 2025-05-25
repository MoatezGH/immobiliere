@extends('layouts.app')
@section('pageTitle')
Qui sommes nous
@endsection
@section('content')
<div class="about-area py-120 mb-30">
<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <div class="about-left">
                <div class="about-img">
                    <img src="{{ asset('about_us.jpg')}}" alt="">
                </div>
                <div class="about-shape">
                    <img src="assets/img/shape/01.svg" alt="">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="about-right">
                <div class="site-heading mb-3">
                    <span class="site-title-tagline">Qui sommes nous</span>
                    {{-- <h2 class="site-title">
                        We have the most listings and constant updates.
                    </h2> --}}
                </div>
                <p class="about-text">La société <strong>AZUR PLATEFORMES & EVENTS</strong>  est une société Unipersonnelle à Responsabilité Limitée au capital Social : 2000 Dinars. Siège Social : Immeuble Carrefour Bureau N°1-3 Bloc B Avenue Abou Dhabi Hammamet qui a pour objet la réalisation d’activités de prestation de services de marketing y compris la gestion des plateformes pour les annonces. La gestion des toutes activités sur support télématique et l’organisation des événements et des salons.</p>
                <br>
                {{-- <br> --}}
                <p class="about-text mt-2">
                    Immobiliere tn, votre meilleur portail des petites annonces immobilières en Tunisie, des milliers d'annonces sont à votre disposition, annonces immobilières, annonces direct promoteurs, annonces des particuliers. Trouver les meilleures annonces des meilleures agences immobilières et des meilleurs promoteurs immobiliers en Tunisie. Sur Immobiliere.tn vendez, achetez et louez vos biens.
                </p>
                {{-- <div class="about-list-wrapper">
                    <ul class="about-list list-unstyled">
                        <li>
                            <div class="about-icon"><span class="fas fa-check-circle"></span></div>
                            <div class="about-list-text">
                                <p>Take a look at our round up of the best shows</p>
                            </div>
                        </li>
                        <li>
                            <div class="about-icon"><span class="fas fa-check-circle"></span></div>
                            <div class="about-list-text">
                                <p>It has survived not only five centuries</p>
                            </div>
                        </li>
                        <li>
                            <div class="about-icon"><span class="fas fa-check-circle"></span></div>
                            <div class="about-list-text">
                                <p>Lorem Ipsum has been the ndustry standard dummy text</p>
                            </div>
                        </li>
                    </ul>
                </div> --}}
                {{-- <div class="about-bottom">
                    <a href="about.html" class="theme-btn">Read More <i class="fas fa-arrow-right"></i></a>
                </div> --}}
            </div>
        </div>
    </div>
</div>

</div>
@endsection