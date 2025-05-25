<style>
    .text-wrap {
        text-wrap: nowrap !important;
    }

    .header {
        margin-bottom: 95px;
    }

    @media (min-width: 992px) {

        /* Target screens wider than 991px */
        #log_out {
            display: none;
        }

        .header {
            margin-top: 1px;
        }
    }


    .navbar .nav-item .dropdown-submenu a::after {
        right: -2px !important;
    }
</style>


<header class="header">
    <div class="main-navigation" style="color:blue;    background: #fff !important;">
        <nav class="navbar navbar-expand-lg">
            <div class="container custom-nav">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('assets/img/logo/logo.png') }}" class="logo-display" alt="Immobiliere tn">
                    <img src="{{ asset('assets/img/logo/logo-dark.png') }}" class="logo-scrolled" alt="Immobiliere tn">
                </a>
                <div class="mobile-menu-right">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-btn-icon"><i class="far fa-bars" style="
    color: #fc3131;
"></i></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="main_nav">
                    <ul class="navbar-nav">

                        <li class="nav-item "><a class="nav-link " href="/">Accueil</a></li>





                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Immobilier</a>
                            <ul class="dropdown-menu fade-down">

                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">Agences & Particuliers</a>
                                    <ul class="dropdown-menu">
                                        <form action="{{ route('all_properties') }}" method="GET">
                                            @csrf
                                            <li>
<a  class="dropdown-item" href="https://immobiliere.tn/cherche/appartement-vente">A Vendre

                                                </a></li>
                                            <input type="hidden" name="operation_id" value="2">
                                        </form>

                                        <form action="{{ route('all_properties') }}" method="GET">
                                            @csrf
                                            <li><a  class="dropdown-item" href="https://immobiliere.tn/cherche/appartement-location">A Louer

                                                </a></li>
                                            <input type="hidden" name="operation_id" value="1">
                                        </form>



                                    </ul>
                                </li>

                                {{-- <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">A louer</a>
                                    <ul class="dropdown-menu">
                                        @foreach ($categories as $value)
                                            <li><a class="dropdown-item" href="#">{{ $value->name  }}</a>
                        </li>
                        @endforeach
                    </ul>
                    </li> --}}

                    <li class="dropdown-submenu">
                        <a class="dropdown-item " href="{{ Route('all_properties_promoteur') }}">Direct
                            Promoteurs</a>

                    </li>

                    </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link " href="{{ route('index_classified_front') }}" style="text-wrap: nowrap !important">Ventes Diverses</a></li>

                    {{-- <li class="nav-item"><a class="nav-link " href="#"
                                style="text-wrap: nowrap !important">Direct
                                Promoteurs</a></li> --}}

                    <li class="nav-item"><a class="nav-link " href="{{ route('index_service_front') }}" style="text-wrap: nowrap !important">Services</a></li>

                    <li class="nav-item"><a class="nav-link" target="__blanck" href="https://maison-dhotes.com/" style="text-wrap: nowrap !important">Maison d’hôtes</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" target="__blanck" href="https://www.location-vacance.com.tn/" style="text-wrap: nowrap !important">Location
                            vacances </a></li>

                    @if (!Auth::check() && !auth()->guard('classified_user')->check() && !auth()->guard('service_user')->check())
                    <li class="nav-item" id="log_out">
                        @csrf <a class="nav-link" href="{{ route('login') }}"><i class="far fa-sign-out"></i>
                            Se Connecter</a>
                    </li>
                    @else
                    @if (auth()->guard('classified_user')->check())
                    <li class="nav-item" id="log_out">
                        <a class="nav-link" href="{{ route('show_profile_classified') }}"><i class="far fa-user"></i>
                            Dashboard</a>
                    </li>
                    @elseif (auth()->guard('service_user')->check())
                    <li class="nav-item" id="log_out">
                        <a class="nav-link" href="{{ route('show_profile_service') }}"><i class="far fa-user"></i>
                            Dashboard</a>
                    </li>
                    @else
                    {{-- {{ dd(auth()->user()) }} --}}
                    @auth
                    @if (auth()->user()->is_admin)


                    <li class="nav-item" id="log_out">
                        <a class="nav-link" href="{{ route('dashboard_admin') }}"><i class="far fa-user"></i>
                            Espace Admin</a>
                    </li>
                    @else
                    <li class="nav-item" id="log_out">
                        <a class="nav-link" href="{{ route('profile_annonceur_immobilier') }}"><i class="far fa-user"></i>
                            Dashboard</a>
                    </li>
                    @endif
                    @endauth
                    @endif

                    <li class="nav-item" id="log_out">
                        @csrf <a class="nav-link" href="{{ route('signout') }}"><i class="far fa-sign-out"></i>
                            Log Out</a>
                    </li>
                    @endif




                    </ul>
                    <div class="header-nav-right">
                        <div class="header-account">
                            @if (!Auth::check() && !auth()->guard('classified_user')->check() && !auth()->guard('service_user')->check())

                            <a href="{{ route('login') }}" class="header-account-link"><i class="far fa-user-circle"></i>
                                Se Connecter</a>
                            @else
                            @auth

                            @if (auth()->guard('web')->check())
                            @if (!auth()->user()->is_admin)
                            @php
                            // $logo = auth()->user()->logo();
                            // dd($logo);
                            $user_logo = null;
                            if (auth()->user()->store) {
                            $user_logo = auth()->user()->store->logo;
                            }

                            @endphp
                            <div class="dropdown">
                                <div data-bs-toggle="dropdown" aria-expanded="false">

                                    <img src="
                                        {{ asset($user_logo ? 'uploads/store_logos/' . $user_logo : 'assets/img/account/user.jpg') }} " alt="">
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile_annonceur_immobilier') }}"><i class="far fa-user"></i>
                                            Mon Compte</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" @can('isAgent') href="{{ route('all_user_property') }}" @else href="{{ route('all_promoteur_property') }}" @endcan><i class="far fa-layer-group"></i>
                                            Mes Annonces</a>
                                    </li>
                                    <li>
                                        @csrf <a class="dropdown-item" href="{{ route('signout') }}"><i class="far fa-sign-out"></i>
                                            Log Out</a>


                                    </li>
                                </ul>
                            </div>
                            @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard_admin') }}" style="text-wrap: nowrap !important">Espace Admin</a></li>
                            @endif
                            @endif


                            @endauth
                            @if (auth()->guard('classified_user')->check())
                            @include('includes.classified')
                            @elseif(auth()->guard('service_user')->check())
                            @include('includes.service')
                            @endif
                            @endif


                        </div>
                        <div class="header-btn">
                            
                            @include('includes.button_add')
                            

                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>

</header>