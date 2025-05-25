<footer class="footer-area">
    <div class="footer-widget">
        <div class="container">
            <div class="row footer-widget-wrapper pt-100 pb-70">
                <div class="col-md-6 col-lg-3">
                    <div class="footer-widget-box about-us">
                        <a href="#" class="footer-logo">
                            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Immobiliere tn">
                        </a>
                        <p class="mb-4" style="color: #ffffff;">
                            Immobiliere.tn, le meilleur site immobilier en Tunisie. Annonce immobilière. Milliers d'annonces sont à votre disposition: appartement, maison, terrain, local commercial, ferme et villa à vendre et à louer. Promouvoir votre entreprise sur notre Annuaire des Services Divers. Sur immobiliere.tn vendez, achetez et louez.
                        </p>

                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Pages</h4>
                        <ul class="footer-list">
                            <li><a href="{{ url('/') }}"><i class="fas fa-angle-double-right"></i>Accueil</a></li>
                            <li><a href="{{ url('/cherche/appartement-vente') }}"><i class="fas fa-angle-double-right"></i> A vendre</a></li>
                            <li><a href="{{ url('/cherche/appartement-location') }}"><i class="fas fa-angle-double-right"></i> A louer</a></li>
                            <li><a href="{{ route('all_properties_promoteur') }}"><i
                                        class="fas fa-angle-double-right"></i> Direct
                                    Promoteurs</a>

                                    
                            </li>

                            <li><a href="{{route('index_service_front')}}"><i class="fas fa-angle-double-right"></i> Services</a></li>

                            <li><a href="{{route('index_classified_front')}}"><i class="fas fa-angle-double-right"></i> Ventes Diverses</a></li>

                        </ul>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Liens</h4>
                        <ul class="footer-list">
                            <li><a href="#"><i class="fas fa-angle-double-right"></i>Prix & Packs</a></li>
                            <li><a href="{{ route('about_us') }}"><i class="fas fa-angle-double-right"></i> Qui sommes nous</a>
                            </li>
                            <li><a href="{{ route('term_condition') }}"><i class="fas fa-angle-double-right"></i> Conditions générales
                                    d'utilisation</a></li>
                            <li><a href="{{ route('contact') }}"><i class="fas fa-angle-double-right"></i> Contactez-nous</a>
                            </li>

                        </ul>
                    </div>
                </div>
                {{-- <div class="col-md-6 col-lg-4">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Lien</h4>
                            <ul class="footer-contact">
                                <li><a href="#"><i class="fas fa-angle-double-right"></i>Accueil</a></li>
                                <li><a href="https://immobiliere.tn/search/appartement-vente"><span class="mdi mdi-facebook mdi-24px"></span>A vendre</a></li>
                                <li><a href="mailto:contact@les-annonces"><i
                                            class="far fa-envelope"></i>contact@les-annonces</a></li>
                            </ul>
                        </div>
                    </div> --}}
                <div class="col-md-6 col-lg-3">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Contact</h4>
                        <ul class="footer-contact">
                            <li><a href="tel:+21695631100"><i class="far fa-phone"></i>+216 95 631 100</a></li>
                            <li><i class="far fa-map-marker-alt"></i>Immeuble Carrefour Hammamet</li>
                            
<li><a href="mailto:contact@immobiliere.tn"><i
                                        class="far fa-envelope"></i>contact@immobiliere.tn</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <p class="copyright-text">
                        &copy; Copyright <span>{{ date('Y') }}</span> <a href="https://immobiliere.tn/">
                            immobiliere.tn </a> Tous droits réservés
                    </p>

                </div>
                <div class="col-md-6 align-self-center">
                    <ul class="footer-social">
                        <li><a href="https://www.facebook.com/share/18gzgK8w89/"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="https://www.instagram.com/immobiliere_tn/?igsh=MXVxZmZlOXc0M2Vlbw%3D%3D"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="https://www.linkedin.com/in/immobiliere-tn?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a href="https://www.youtube.com/@immobiliere_tn?si=_CPOdtaTKnxYA0vC"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
