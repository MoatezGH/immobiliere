@extends('layouts.app')
@section('meta')
    <!-- Open Graph meta tags -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $property[0]->title }}">
    <meta property="og:description" content="{{ $property[0]->description }}">
    <meta property="og:image" content="{{ $property[0]->get_meta_image() }}">
    <meta property="og:type" content="website" />

    {{-- @if (config('services.facebook.app_id'))
        <meta property="fb:app_id" content="{{ config('services.facebook.app_id') }}">
    @endif --}}
@endsection
@section('pageTitle')
    {{ $property[0]->title }}
@endsection
@section('content')

    <style>
        @media only screen and (min-width: 600px) {

            .sli {
                height: 400px;
                width: 100%;
            }

            .site-breadcrumb {
                padding-top: 0px;
                padding-bottom: 0px;

            }
        }

        .product-favorite,
        .product-status {
            font-size: 12px;
        }

        .product-info>p,
        .product-date,
        .product-category-title {
            font-size: 12px;
        }

        li>img {
            height: 100%;
        }

        .img_sl {
            /* width: 825px !important; */
            width: 880px !important;
            height: 550px !important;
        }

        .flex-control-nav {
            display: flex !important;
        }

        @media only screen and (max-width: 600px) {
            .img_sl {
                /* width: 366px !important;
                                                                                                                                                                                                                        height: 228px !important; */
                width: 390px !important;
                height: 260px !important;

            }

            .product-info>p,
            .product-date,
            .product-category-title {
                font-size: 16px;
            }

            

            .flex-control-nav {
                display: flex !important;
            }


            .site-breadcrumb {
                background-size: contain !important;
                /* margin-top: -200px !important; */
            }


            

            .site-breadcrumb {
                padding-top: 50px;
                padding-bottom: 50px;

            }


        }

        .favorited .fa-heart {
            color: red;
        }

        .fa-heart-o {
            color: gray;
        }

    </style>



    {{-- <div class="site-breadcrumb">

        <div class="container">
            <img class="sli" src="{{ asset('images/new/8.png') }}" alt="">
        </div>
    </div> --}}
    {{-- {{ dd("test") }} --}}
    @include('includes.slider')


    <div class="product-single py-120">
        <div class="container">

            <div class="row">

                <div class="col-lg-9 mb-4">
                    @if ($errors->has('error'))
                        <div class="alert alert-danger">
                            {{ $errors->first('error') }}
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if (session()->has('successFav'))
                        <div class="alert alert-success">
                            {{ session()->get('successFav') }}
                        </div>
                    @endif



                    <div class="product-single-wrapper">
                        <div class="product-single-top mt-0 mb-4">
                            <div class="product-single-title">

                                <h1 class="title__" style="font-size: 28px;">{{ strtoupper($property[0]->title) }}</h1>
                                <p><img src="{{ asset('icon_png/calendar.png') }}" alt="" style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        Publié le {{ $property[0]->created_at }}</p>
                            </div>
                            <div class="product-single-btn">

                                @if (Auth::check())
                                    @if (Auth::user()->favorites->contains('favoritable_id', $property[0]->id))
                                        <a onclick="submitAdd()" style="border: 1px solid #fc3131;"
                                            class="favorite-button favorited" href="#">
                                                <i class="fa-solid fa-heart"></i>
                                            </a>
                                        <form style="display:none" id="add_fav"
                                            action="{{ route('favorites.store', ['favoritableType' => 'App\Models\PromoteurProperty', 'favoritableId' => $property[0]->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')

                                        </form>
                                    @else
                                        <a onclick="submitDelete()" class="favorite-button" href="#"><i
                                                class="far fa-heart"></i></a>
                                        <form style="display:none" id="del_fav"
                                            action="{{ route('favorites.store', ['favoritableType' => 'App\Models\PromoteurProperty', 'favoritableId' => $property[0]->id]) }}"
                                            method="POST">
                                            @csrf

                                        </form>
                                    @endif
                                @else
                                    <a onclick="goLogin()" class="favorite-button" href="#"><i
                                            class="far fa-heart"></i></a>
                                    <form id="goLogin" style="display:none" action="{{ route('login') }}" method="GET">
                                        @csrf

                                    </form>
                                    <!-- Display login link or button -->
                                @endif
                                <a href="#" onclick="shareOnFacebook()"><i class="far fa-share-alt"></i></a>
                            </div>
                        </div>
                        <div class="product-single-slider">
                            <div class="item-gallery">
                                <div class="flexslider-thumbnails">
                                    <ul class="slides">

                                        @foreach ($property[0]->images as $item)
                                            <li data-thumb="{{ asset('uploads/promoteur_property/' . $item->title) }}">
                                                <img src="{{ asset('uploads/promoteur_property/' . $item->title) }}"
                                                    alt="{{$property[0]->title}}" class="img_sl">
                                            </li>
                                        @endforeach


                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="product-single-price" style="color:#fc3131">
                            {{ $property[0]->price_total }} DT
                        </div>
                        <img src="{{ asset('icon_png/ref.png') }}" alt="" style="width:45px">
                        <span style="color: #fc3131;margin-left: -10px;">
                            {{ strtoupper($property[0]->ref) }}
                        </span>
                        <div class="product-single-moreinfo">

                            <ul>
                                <li><img src="{{ asset('icon_png/type.png') }}" alt="{{$property[0]->category->name}}" style="width:35px"><span
                                        style="
                                        margin-left: -5px;
                                    ">{{ strtoupper($property[0]->category->name) }}</span>
                                </li>
                                <li><img src="{{ asset('icon_png/operation.png') }}" alt="{{$property[0]->operation->name}}"
                                        style="width:35px"><span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        {{ strtoupper($property[0]->operation->name) }}</li>

                                <li><img src="{{ asset('icon_png/location.png') }}" alt="{{ $property[0]->city->name }},
                                        {{ $property[0]->area->name }}" style="width:35px"><span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        {{ $property[0]->city->name }},
                                        {{ $property[0]->area->name }}</span></li>
                                <li><img src="{{ asset('icon_png/eyes.png') }}" alt="" style="width:35px"><span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        {{ $property[0]->count_views }} Vues</li>
                            </ul>
                        </div>
                        <div class="product-single-feature" style="margin-bottom:20px">
                            <h4 class="mb-3">Details</h4>

                            @if (
                                $property[0]->nb_bedroom != 0 ||
                                    $property[0]->nb_living != 0 ||
                                    $property[0]->nb_bathroom != 0 ||
                                    $property[0]->nb_kitchen != 0 ||
                                    $property[0]->suite_parental != 0 ||
                                    $property[0]->salle_eau != 0 ||
                                    $property[0]->nb_etage != 0 ||
                                    $property[0]->nb_terrasse != 0)
                                <div class="product-single-feature-list">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <ul>
                                                @if ($property[0]->nb_bedroom != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/bedroom.png') }}" alt=""
                                                            style="width:55px">

                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Chambre</span>
                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->nb_bedroom }}</span>

                                                    </li>
                                                @endif

                                                {{-- @if ($property[0]->nb_kitchen != 0) --}}
                                                <li>
                                                    <img src="{{ asset('icon_png/kitchen.png') }}" alt=""
                                                        style="width:55px">
                                                    <span
                                                        style="
                                                                margin-left: -10px;
                                                            ">Cuisine</span>
                                                    <span style="color: #fc3131;padding: 2px;border-radius: 5px;">
                                                        @if ($property[0]->nb_kitchen != 0)
                                                            Équipé
                                                        @else
                                                            Non équipé
                                                        @endif
                                                    </span>
                                                </li>
                                                {{-- @endif --}}
                                                @if ($property[0]->suite_parental != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/bedroom.png') }}" alt=""
                                                            style="width:55px">

                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Suite
                                                            Parental</span>
                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->suite_parental }}</span>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                        <div class="col-lg-4">
                                            <ul>
                                                @if ($property[0]->nb_living != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/salon.png') }}" alt=""
                                                            style="width:55px">
                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Salon</span>

                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->nb_living }}</span>
                                                    </li>
                                                @endif
                                                @if ($property[0]->nb_bathroom != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/bethroom.png') }}" alt=""
                                                            style="width:55px">
                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Salle
                                                            de bains</span>
                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->nb_bathroom }}</span>
                                                    </li>
                                                @endif

                                                @if ($property[0]->salle_eau != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/salle_eau.png') }}" alt=""
                                                            style="width:55px">
                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Salle
                                                            d'eau</span>
                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->salle_eau }}</span>
                                                    </li>
                                                @endif


                                            </ul>
                                        </div>

                                        <div class="col-lg-4">
                                            <ul>
                                                @if ($property[0]->nb_etage != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/etage.png') }}" alt=""
                                                            style="width:55px">
                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Numéro
                                                            étage</span>
                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->nb_etage == 'rdc' ? strtoupper($property[0]->nb_etage) : $property[0]->nb_etage }}</span>
                                                    </li>
                                                @endif
                                                @if ($property[0]->nb_terrasse != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/terrase.png') }}" alt=""
                                                            style="width:55px">
                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Terrasse</span>
                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->nb_terrasse }}</span>
                                                    </li>
                                                @endif




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="product-single-feature">
                            <h4 class="mb-3">Équipements</h4>

                            <div class="product-single-feature-list">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <ul>
                                            @if ($property[0]->wifi == 1)
                                                <li><i class="fad fa-circle-check"></i> wifi</li>
                                            @endif
                                            @if ($property[0]->balcon == 1)
                                                <li><img style="
                                                            width: 55px;
                                                        "
                                                        src="{{ asset('icon_png/balcon.png') }}" alt="balcon">balcon
                                                </li>
                                            @endif

                                            @if ($property[0]->garden == 1)
                                                <li><i class="fad fa-circle-check"></i> Jardin</li>
                                            @endif

                                            @if ($property[0]->garage == 1)
                                                <li><img style="
                                                        width: 55px;
                                                    "
                                                        src="{{ asset('icon_png/garage.png') }}" alt="garage"> Garage
                                                </li>
                                            @endif

                                            @if ($property[0]->parking == 1)
                                                <li><img style="
                                                            width: 55px;
                                                        "
                                                        src="{{ asset('icon_png/parking.png') }}" alt="parking"> Parking
                                                </li>
                                            @endif
                                            @if ($property[0]->ascenseur == 1)
                                                <li><img style="
                                                            width: 55px;
                                                        "
                                                        src="{{ asset('icon_png/asc.png') }}" alt="Ascenseur"> Ascenseur
                                                </li>
                                            @endif

                                            @if ($property[0]->heating == 1)
                                                <li><img style="
                                                            width: 55px;
                                                        "
                                                        src="{{ asset('icon_png/chauffage.png') }}" alt="chauffage">
                                                    Chauffage</li>
                                            @endif







                                        </ul>
                                    </div>
                                    <div class="col-lg-4">
                                        <ul>


                                            @if ($property[0]->climatisation == 1)
                                                <li><img style="
                                                            width: 55px;
                                                        "
                                                        src="{{ asset('icon_png/clim.png') }}" alt="air_condition">
                                                    Climatisation Central</li>
                                            @endif

                                            @if ($property[0]->system_alarm == 1)
                                                <li> <img
                                                        style="
                                                                width: 55px;
                                                            "
                                                        src="{{ asset('icon_png/camera.png') }}" alt="camera"> Système
                                                    alarme</li>
                                            @endif
                                            @if ($property[0]->piscine == 1)
                                                <li> <img
                                                        style="
                                                        width: 55px;
                                                    "
                                                        src="{{ asset('icon_png/piscine.png') }}" alt="piscine"> Piscine
                                                    Privée</li>
                                            @endif

                                            @if ($property[0]->swimming_pool_public == 1)
                                                <li> <img
                                                        style="
                                                        width: 55px;
                                                    "
                                                        src="{{ asset('icon_png/picine_public.png') }}" alt="piscine">
                                                    Piscine
                                                    Collective</li>
                                            @endif

                                            @if ($property[0]->split == 1)
                                                <li> <img
                                                        style="
                                                        width: 55px;
                                                    "
                                                        src="{{ asset('icon_png/split.png') }}" alt="piscine"> Split
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- -----------------Details Sur Le Prix--------------------------- --}}

                        <div class="product-single-description mt-4">
                            <h4 class="mb-3">Détails des Prix</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul>
                                        @if ($property[0]->price_total !== null)
                                            <li><i class="fad fa-circle-check"
                                                    style="
                                            color: #fc3131;
                                        "></i>
                                                Prix Total :
                                                {{ $property[0]->price_total }} (TND)</li>
                                        @endif
                                        @if ($property[0]->price_metre !== null)
                                            <li><i class="fad fa-circle-check"
                                                    style="
                                            color: #fc3131;
                                        "></i>
                                                Prix du m² :
                                                {{ $property[0]->price_metre }} (TND)</li>
                                        @endif
                                        @if ($property[0]->price_metre_terrasse !== null)
                                            <li><i class="fad fa-circle-check"
                                                    style="
                                            color: #fc3131;
                                        "></i>
                                                Prix du m² Terrasse :
                                                {{ $property[0]->price_metre_terrasse }} (TND)</li>
                                        @endif


                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul>
                                        @if ($property[0]->price_metre_jardin !== null)
                                            <li><i class="fad fa-circle-check"
                                                    style="
                                            color: #fc3131;
                                        "></i>
                                                Prix du m² jardin :
                                                {{ $property[0]->price_metre_jardin }} (TND)</li>
                                        @endif
                                        @if ($property[0]->price_cellier !== null)
                                            <li><i class="fad fa-circle-check"
                                                    style="
                                            color: #fc3131;
                                        "></i>
                                                Prix cellier :
                                                {{ $property[0]->price_cellier }} (TND)</li>
                                        @endif
                                        @if ($property[0]->price_parking !== null)
                                            <li><i class="fad fa-circle-check"
                                                    style="
                                            color: #fc3131;
                                        "></i>
                                                Prix place parking :
                                                {{ $property[0]->price_parking }} (TND)</li>
                                        @endif


                                    </ul>
                                </div>
                            </div>

                        </div>



                        {{-- -----------------Surface--------------------------- --}}
                        <div class="product-single-description mt-4">
                            <h4 class="mb-3">Surface</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul>
                                        @if ($property[0]->surface_totale !== null)
                                            <li><i class="fad fa-circle-check"
                                                    style="
                                            color: #fc3131;
                                        "></i>
                                                Surface Total :
                                                {{ $property[0]->surface_totale }} (m²)</li>
                                        @endif

                                        @if ($property[0]->surface_habitable !== null)
                                            <li><i class="fad fa-circle-check"
                                                    style="
                                            color: #fc3131;
                                        "></i>
                                                Surface Habitable :
                                                {{ $property[0]->surface_habitable }} (m²)</li>
                                        @endif

                                        @if ($property[0]->surface_terrasse !== null)
                                            <li><i class="fad fa-circle-check"
                                                    style="
                                            color: #fc3131;
                                        "></i>
                                                Surface Terrasse :
                                                {{ $property[0]->surface_terrasse }} (m²)</li>
                                        @endif

                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul>
                                        @if ($property[0]->surface_jardin !== null)
                                            <li><i class="fad fa-circle-check"
                                                    style="
                                            color: #fc3131;
                                        "></i>
                                                Surface Jardin :
                                                {{ $property[0]->surface_jardin }} (m²)</li>
                                        @endif
                                        @if ($property[0]->surface_cellier !== null)
                                            <li><i class="fad fa-circle-check"
                                                    style="
                                            color: #fc3131;
                                        "></i>
                                                Surface Cellier :
                                                {{ $property[0]->surface_cellier }} (m²)</li>
                                        @endif


                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="product-single-description mt-4">
                            <h4 class="mb-3">Remise des clés</h4>
                            <p>
                                <img style="
                                                        width: 75px;
                                                    "
                                    src="{{ asset('icon_png/key.png') }}" alt="piscine">
                                <strong
                                    style="
                                                    margin-left: -9px;
                                                ">{{ ucfirst($property[0]->remise_des_clés) }}
                                </strong>
                            </p>

                        </div>

                        <div class="product-single-description mt-4 title__">
                            <h4 class="mb-3">Description</h4>
                            <p>
                                {{ $property[0]->description }}
                            </p>

                        </div>
                        @if ($property[0]->vedio_path)
                            <div class="product-single-description mt-4">

                                <h4 class="mb-2"> Vidéo
                                </h4>

                                <video id="videoPreview" width="320" height="240" controls
                                    @if (!$property[0]->vedio_path) style="display:none" @endif>
                                    <source id="videoSource"
                                        src="{{ asset($property[0]->vedio_path ? 'uploads/videos/properties_promoteur/' . $property[0]->vedio_path : '') }}"
                                        type="video/mp4">

                                </video>
                            </div>
                        @endif
                        {{-- pub --}}
                        {{-- {{ dd($user) }} --}}
                        {{-- <div class="blog-comments-form">
                            <h4 class="mb-4">Informations sur l'annonceur</h4>
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class=" ">
                                        <label class="star-label"
                                            style="
                                                color: black;
                                            "><i
                                                class="fa fa-user-circle"
                                                style="
                                                color: #fc3131;
                                            "></i>
                                            {{ $user->first_name }} {{ $user->last_name }}</label>
                                        @if (isset($user->phone) && !empty($user->phone))
                                        <br>

                                            <label class="star-label"
                                                style="
                                                    color: black;
                                                    "><i
                                                    class="fa fa-phone-circle"
                                                    style="
                                                            color: #fc3131;
                                                        "></i>
                                                {{ $user->phone }}</label>
                                        @endif
                                        <br>
                                        <label class="star-label"
                                            style="
                                                    color: black;
                                                "><i
                                                class="fa fa-envelope-circle"
                                                style="
                                                color: #fc3131;
                                            "></i>
                                            {{ $user->user->email }}</label>


                                    </div>
                                </div>

                            </div>
                            
                        </div> --}}
                        {{-- endpub --}}
                        <div class="blog-comments-form">
                            <div class="product-sidebar mb-3">
                                <div class="product-single-sidebar-item">

                                    <h5 class="title">Informations sur l'annonceur</h5>



                                    <div class="product-single-author" style="overflow:auto">

                                        <img src="{{ asset($user_logo ? 'uploads/store_logos/' . $user_logo : 'assets/img/account/user0.jpg') }} "
                                            alt="">




                                        <h4><a href="#">
                                                {{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}
                                            </a></h4>
                                        {{-- <span>{{ $property[0]->user->email }}</span> --}}
                                        {{-- {{dd(str_replace("/"," ",$property[0]->user->userPhone()))}} --}}

                                        {{-- {{ dd($user->phone ?? $user->mobile) }} --}}
                                        @if (($user && $user->phone) || $user->mobile)
                                            <div class="product-single-author-phone">
                                                <span>
                                                    <i class="far fa-phone"></i>
                                                    <span class="author-number">
                                                        {{-- {{ dd($user) }} --}}
                                                        {{ substr($user->phone ?? $user->mobile, 0, 5) }}XXXX</span>
                                                    <span
                                                        class="author-reveal-number">{{ $user->phone ?? $user->mobile }}</span>
                                                </span>
                                                <p data-user-id="{{ $property[0]->user->id }}"
                                                    id="display-number-button">Cliquez pour afficher le numéro de téléphone
                                                </p>
                                            </div>
                                            <a href="tel:{{ $user->phone ?? $user->mobile }}" id="call-button"
                                                data-user-id="{{ $property[0]->user->id }}"
                                                data-phone="{{ $user->phone ?? $user->mobile }}" 
                                                class="theme-border-btn w-100 mt-4"><i class="far fa-phone"></i>
                                                Appeller</a>
                                        @endif
                                    </div>




                                    {{-- pub --}}

                                    {{-- endpub --}}

                                </div>
                            </div>
                        </div>
                        {{-- test --}}

                        <div class="blog-comments-form">
                            <div class="product-sidebar mb-3">
                                <h4 class="mb-2 title__" onclick="getmessage()"
                                    style="cursor: pointer;text-align: center;
                                    color: #fc3131;">
                                    Envoyer Message <i class="fa fa-plus-circle"></i></h4>
                                <form action="{{ route('send.email.client') }}" method="POST" id="message-form"
                                    style="display:none">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="Nom & Prénom" id="name" name="name">
                                            </div>
                                            @include('message_session.error_field_message', [
                                                'fieldName' => 'name',
                                            ])
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="E-mail" id="email" name="email">
                                            </div>
                                            @include('message_session.error_field_message', [
                                                'fieldName' => 'email',
                                            ])
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="number" min="0"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    placeholder="N° Tel" id="phone" name="phone">
                                            </div>
                                            @include('message_session.error_field_message', [
                                                'fieldName' => 'phone',
                                            ])
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control @error('message') is-invalid @enderror" rows="3" id="message" name="message"
                                                    placeholder="Message*">Je suis intéressé par cette annonce [REF: {{ $property[0]->ref }} ] et j'aimerais avoir plus de détails.
                                                </textarea>

                                            </div>
                                            @include('message_session.error_field_message', [
                                                'fieldName' => 'message',
                                            ])
                                            <input type="hidden" name="type" value="property-promoteur">
                                            <input type="hidden" name="property_id" value="{{ $property[0]->id }}">

                                            <button type="submit" class="theme-btn">Envoyer <i
                                                    class="far fa-paper-plane"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        {{-- endtest --}}

                        @if (count($propertyRelated) > 0)
                            <div class="product-single-related mt-5">
                                <h4 class="mb-4">Annonces Similaires</h4>
                                <div class="row">
                                    {{-- <div class="col-10"> --}}

                                    @foreach ($propertyRelated as $item)
                                        <div class="col-md-6 col-lg-4">
                                            @include('includes.item_promoteur_property')
                                        </div>
                                    @endforeach
                                    {{-- </div> --}}

                                </div>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="col-lg-3">

                    <div class="product-sidebar mb-3">
                        <div class="product-single-sidebar-item">

                            <h5 class="title">PUBLICITÉS</h5>

                            <div class="blog-item-img" style="overflow:auto">
                                @foreach ($ads as $ad)
                                    <a href="{{ $ad->url ? route('ad.click', ['id' => $ad->id]) : '#' }}" class="mb-4"
                                        title="{{ ucfirst($ad->description) }}">
                                        <img src="{{ asset($ad ? 'uploads/ads/' . $ad->alt : 'assets/img/account/user0.jpg') }} "
                                            alt="">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>

    <form id="call-action-form" method="POST" action="{{ route('save_statistique') }}" style="display: none;">
        @csrf
        <input type="hidden" name="user_id" id="user-id-input">
        <input type="hidden" name="action_type" value="call">
        <input type="hidden" name="phone" id="phone-input">
    </form>
    {{-- statistique --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('#call-button').on('click', function(e) {

            //     document.getElementById('call-button').addEventListener('click', function(e) {
            //         e.preventDefault(); // Prevent the default link action

            //         // Get the data attributes
            //         var userId = this.getAttribute('data-user-id');
            //         var phone = this.getAttribute('data-phone');
            //         console.log("this" + userId);
            //         console.log(phone);

            //         // Set the form inputs
            //         document.getElementById('user-id-input').value = userId;
            //         document.getElementById('phone-input').value = phone;

            //         // Submit the form
            //         document.getElementById('call-action-form').submit();
            //     });

            //     var userId = $(this).data('user-id');
            //     var action_type = 'call';



            //     $.ajax({
            //         url: ' {{ route('save_statistique') }}',
            //         type: 'POST',
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             user_id: userId,
            //             action_type: action_type

            //         },
            //         success: function(response) {
            //             if (response.success) {
            //                 window.location.href = 'tel:' + phone;
            //             }
            //         }
            //     });
            // });

            $('#call-button').on('click', function(e) {
                e.preventDefault(); // Prevent the default button action

                // Get the data attributes
                var userId = $(this).data('user-id');
                var phone = $(this).data('phone');
                console.log("User ID: " + userId);
                console.log("Phone: " + phone);

                // Set the form inputs
                $('#user-id-input').val(userId);
                $('#phone-input').val(phone);

                // Submit the form
                // Submit the form
                $.ajax({
                type: 'POST',
                url: $('#call-action-form').attr('action'),
                data: $('#call-action-form').serialize(),
                success: function(response) {
                    // On success, redirect to the dialer
                    window.location.href = 'tel:' + phone;
                },
                error: function(error) {
                    console.error("Error submitting form:", error);
                    // Optionally, handle the error
                }
            });
            });


            $('#display-number-button').on('click', function() {
                var userId = $(this).data('user-id');
                console.log(userId);

                var action = 'displayed_number';

                $.ajax({
                    url: ' {{ route('save_statistique') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        action_type: action
                    },

                });
            });
        });
    </script>
    {{-- end statistique --}}
    <script>
        function getmessage() {
            var divItem = document.getElementById("message-form");
            if (divItem.style.display === 'none') {
                divItem.style.display = 'block';
            } else {
                divItem.style.display = 'none';
            }
        }

        function submitAdd() {
            document.getElementById('add_fav').submit();
        }

        function submitDelete() {
            document.getElementById('del_fav').submit();
        }

        function goLogin() {
            document.getElementById('goLogin').submit();
        }

        function shareOnFacebook() {
            var url = encodeURIComponent('{{ url()->current() }}');
            var shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    </script>
@endsection
	