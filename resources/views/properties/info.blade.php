@extends('layouts.app')
@section('meta')
    <!-- Open Graph meta tags -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $property[0]->title }}">
    <meta property="og:description" content="{{ $property[0]->description }}">
    <meta property="og:image" content="{{ $property[0]->get_meta_image() }}">
    <meta property="og:type" content="website" />

    @if (config('services.facebook.app_id'))
        <meta property="fb:app_id" content="{{ config('services.facebook.app_id') }}">
    @endif
@endsection


@section('pageTitle')
    {{ $property[0]->title }}
@endsection
@section('content')
    {{-- {{ dd($user_logo) }} --}}

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

        .img_sl {
            /* width: 825px !important; */
            width: 880px !important;
            height: 550px !important;
        }

        .product-info>p,
        .product-date,
        .product-category-title {
            font-size: 12px;
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
                padding-top: 50px;
                padding-bottom: 50px;

            }
.product-single {
padding-top:0px !important;}
        }

        .favorited .fa-heart {
            color: red;

        }

        .fa-heart-o {
            color: gray;
        }

        .product-favorite,
        .product-status {
            font-size: 12px;
        }

    </style>

    {{-- <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
        
        <div class="container">
            <img class="sli" src="{{ asset('images/new/5.png') }}" alt="">
        </div>
    </div> --}}
    @include("includes.slider")

    {{-- <div class="product-single py-120"> --}}
    <div class="product-single py-120">


        <div class="container">
            <div class="row">




                <div class="col-lg-9 ">
                    @if (session()->has('successFav'))
                        <div class="alert alert-success">
                            {{ session()->get('successFav') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <div class="product-single-wrapper">


                        <div class="product-single-top mt-0 mb-4">
                            <div class="product-single-title">
                                {{-- <h3>{{ mb_substr(ucfirst($property[0]->title), 0, 34) }}</h3> --}}
                                <h1 class="title__" style="font-size: 28px;">{{ strtoupper($property[0]->title) }}</h1>
                                <p><img src="{{ asset('icon_png/calendar.png') }}" alt="" style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        Publié le {{ $property[0]->created_at }}</p>
                            </div>
                            <div class="product-single-btn">
                                {{-- <a class="favorite-button" href="#" data-property-id="{{ $property[0]->id }}"><i
                                        class="far fa-heart"></i></a> --}}


                                {{-- {{ dd(Auth::user()->favorites->contains('favoritableId', $property[0]->id)) }} --}}
                                @if (Auth::check())
                                    @if (Auth::user()->favorites->contains('favoritable_id', $property[0]->id))
                                        <a onclick="submitAdd()" style="border: 1px solid #fc3131;"
                                            class="favorite-button favorited" href="#"><i
                                                class="far fa-heart"></i></a>
                                        <form style="display:none" id="add_fav"
                                            action="{{ route('favorites.store', ['favoritableType' => 'App\Models\Property', 'favoritableId' => $property[0]->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')

                                        </form>
                                    @else
                                        <a onclick="submitDelete()" class="favorite-button" href="#"><i
                                                class="far fa-heart"></i></a>
                                        <form style="display:none" id="del_fav"
                                            action="{{ route('favorites.store', ['favoritableType' => 'App\Models\Property', 'favoritableId' => $property[0]->id]) }}"
                                            method="POST">
                                            @csrf

                                        </form>
                                    @endif
                                @else
                                    <a onclick="goLogin()" class="favorite-button" href="#"><i class="fa-solid fa-heart"></i></a>
                                    <form id="goLogin" style="display:none" action="{{ route('login') }}" method="GET">
                                        @csrf

                                    </form>
                                    <!-- Display login link or button -->
                                @endif

                                <a href="#"
                                    onclick="shareOnFacebook('{{ $property[0]->title }}','{{ $property[0]->get_meta_image() }}','{{ $property[0]->slug }}')"><i
                                        class="far fa-share-alt"></i></a>
                                {{-- <a href="#"><i class="far fa-flag"></i></a> --}}
                                {{-- REF:
                                <span style="color: #fc3131;">
                                    {{ strtoupper($property[0]->ref) }}
                                </span> --}}

                            </div>
                        </div>
                        <div class="product-single-slider">
                            <div class="item-gallery">
                                <div class="flexslider-thumbnails">
                                    <ul class="slides">
                                        @if (count($property[0]->pictures) > 0)
                                            @foreach ($property[0]->pictures as $item)
                                                @php

                                                    $imagePath = 'uploads/property_photo/' . $item->alt;

                                                    $defaultImagePath = 'assets/img/product/slider-1.jpg';

                                                    // Check if the image file exists in the folder
                                                    if (file_exists(public_path($imagePath))) {
                                                        $thumbPath = asset($imagePath);
                                                        $imageSrc = asset($imagePath);
                                                    } else {
                                                        // If image file not found, use default image
                                                        $thumbPath = asset($defaultImagePath);
                                                        $imageSrc = asset($defaultImagePath);
                                                    }
                                                @endphp

                                                <li data-thumb="{{ $thumbPath }}">
                                                    <img src="{{ $imageSrc }}" alt="{{$property[0]->title}}" class="img_sl">
                                                </li>
                                            @endforeach
                                        @else
                                            <li
                                                data-thumb="{{ asset('uploads/main_picture/images/properties/' . $property[0]->main_picture->alt) }}">
                                                <img src="{{ asset('uploads/main_picture/images/properties/' . $property[0]->main_picture->alt) }}"
                                                    alt="#" class="img_sl">
                                            </li>
                                        @endif


                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="product-single-price" style="color:#fc3131">
                            {{ $property[0]->price }}
                            {{-- {{ number_format($property[0]->price / 1) }} --}}
                            DT

                        </div>
                        <img src="{{ asset('icon_png/ref.png') }}" alt="" style="width:45px">
                        <span style="color: #fc3131;margin-left: -10px;">
                            {{ strtoupper($property[0]->ref) }}
                        </span>
                        <div class="product-single-moreinfo">
                            <ul>
                                <li><img src="{{ asset('icon_png/type.png') }}" alt="{{$property[0]->category->name}}" style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    ">{{ strtoupper($property[0]->category->name) }}</span>
                                </li>
                                <li><img src="{{ asset('icon_png/operation.png') }}" alt="{{$property[0]->operation->name}}"
                                        style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        {{ strtoupper($property[0]->operation->name) }}</li>

                                <li><img src="{{ asset('icon_png/location.png') }}" alt="{{ $property[0]->city->name }},
                                        {{ $property[0]->area->name }}" style="width:45px">
                                    <span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        {{ $property[0]->city->name }},
                                        {{ $property[0]->area->name }}</span>
                                    {{-- <span
                                        style="margin-left: -5px; display: inline-block; max-width: 150px; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $property[0]->city->name }}, {{ $property[0]->area->name }}
                                    </span> --}}

                                </li>
                                <li><img src="{{ asset('icon_png/eyes.png') }}" alt="" style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        {{ $property[0]->count_views }} Vues</li>
                            </ul>
                        </div>
                        @if (
                            $property[0]->room_number != 0 ||
                                $property[0]->living_room_number != 0 ||
                                $property[0]->bath_room_number != 0 ||
                                $property[0]->kitchen_number != 0 ||
                                $property[0]->plot_area != 0 ||
                                $property[0]->floor_area != 0)
                            <div class="product-single-feature"
                                style="margin-bottom:20px;padding-bottom: 10px;border-bottom: 1px solid rgba(0, 0, 0, 0.08);">
                                <h4 class="mb-3">Détails</h4>

                                <div class="product-single-feature-list">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <ul>
                                                @if ($property[0]->room_number != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/bedroom.png') }}" alt=""
                                                            style="width:55px">
                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Chambre</span>

                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->room_number }}</span>

                                                    </li>
                                                @endif
                                                @if ($property[0]->living_room_number != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/salon.png') }}" alt=""
                                                            style="width:55px">
                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Salon</span>

                                                        <span style="color: #fc3131;padding: 2px;border-radius: 5px;">
                                                            {{ $property[0]->living_room_number }}</span>
                                                    </li>
                                                @endif

                                                @if ($property[0]->floor_area != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/m2.png') }}" alt=""
                                                            style="width:55px">
                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Superficie
                                                            Total</span>

                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->floor_area }}</span>
                                                        (m²)

                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                        <div class="col-lg-4">
                                            <ul>
                                                @if ($property[0]->bath_room_number != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/bethroom.png') }}" alt=""
                                                            style="width:55px">
                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Salle
                                                            de bain</span>
                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->bath_room_number }}</span>
                                                    </li>
                                                @endif
                                                @if ($property[0]->kitchen_number != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/kitchen.png') }}" alt=""
                                                            style="width:55px">
                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Cuisine</span>
                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->kitchen_number }}</span>
                                                    </li>
                                                @endif

                                                @if ($property[0]->plot_area != 0)
                                                    <li>
                                                        <img src="{{ asset('icon_png/m22.png') }}" alt=""
                                                            style="width:55px">
                                                        <span
                                                            style="
                                                                margin-left: -10px;
                                                            ">Superficie
                                                            Couverte</span>

                                                        <span
                                                            style="color: #fc3131;padding: 2px;border-radius: 5px;">{{ $property[0]->plot_area }}</span>
                                                        (m²)

                                                    </li>
                                                @endif
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (
                            $property[0]->wifi == 1 ||
                                $property[0]->balcony == 1 ||
                                $property[0]->garden == 1 ||
                                $property[0]->garage == 1 ||
                                $property[0]->parking == 1 ||
                                $property[0]->elevator == 1 ||
                                $property[0]->heating == 1 ||
                                $property[0]->air_conditioner == 1 ||
                                $property[0]->alarm_system == 1 ||
                                $property[0]->swimming_pool == 1)
                            <div class="product-single-feature"
                                style="margin-bottom:20px;padding-bottom: 10px;border-bottom: 1px solid rgba(0, 0, 0, 0.08);">
                                <h4 class="mb-3">Équipements</h4>

                                <div class="product-single-feature-list">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <ul>
                                                @if ($property[0]->wifi == 1)
                                                    <li>
                                                        <img style="
                                                            width: 55px;
                                                        "
                                                            src="{{ asset('icon_png/wifi.png') }}" alt="wifi">
                                                        wifi
                                                    </li>
                                                @endif
                                                @if ($property[0]->balcony == 1)
                                                    <li>
                                                        <img style="
                                                            width: 55px;
                                                        "
                                                            src="{{ asset('icon_png/balcon.png') }}" alt="balcon">
                                                        balcon
                                                    </li>
                                                @endif
                                                @if ($property[0]->garden == 1)
                                                    <li><img style="
                                                        width: 55px;
                                                    "
                                                            src="{{ asset('icon_png/jardin.png') }}" alt="garden">
                                                        Jardin
                                                    </li>
                                                @endif
                                                @if ($property[0]->garage == 1)
                                                    <li><img style="
                                                        width: 55px;
                                                    "
                                                            src="{{ asset('icon_png/garage.png') }}" alt="garage">
                                                        Garage
                                                    </li>
                                                @endif
                                                @if ($property[0]->parking == 1)
                                                    <li><img style="
                                                            width: 55px;
                                                        "
                                                            src="{{ asset('icon_png/parking.png') }}" alt="parking">
                                                        Parking
                                                    </li>
                                                @endif




                                            </ul>
                                        </div>
                                        <div class="col-lg-4">
                                            <ul>
                                                @if ($property[0]->elevator == 1)
                                                    <li>
                                                        <img style="
                                                            width: 55px;
                                                        "
                                                            src="{{ asset('icon_png/asc.png') }}" alt="Ascenseur">
                                                        Ascenseur
                                                    </li>
                                                @endif
                                                @if ($property[0]->heating == 1)
                                                    <li>
                                                        <img style="
                                                            width: 55px;
                                                        "
                                                            src="{{ asset('icon_png/chauffage.png') }}" alt="chauffage">
                                                        Chauffage
                                                    </li>
                                                @endif
                                                @if ($property[0]->air_conditioner == 1)
                                                    <li>
                                                        <img style="
                                                            width: 55px;
                                                        "
                                                            src="{{ asset('icon_png/clim.png') }}" alt="air_condition">
                                                        Climatisation
                                                    </li>
                                                @endif
                                                @if ($property[0]->alarm_system == 1)
                                                    <li>
                                                        <img style="
                                                                width: 55px;
                                                            "
                                                            src="{{ asset('icon_png/camera.png') }}" alt="camera">
                                                        Système
                                                        alarme
                                                    </li>
                                                @endif
                                                @if ($property[0]->swimming_pool == 1)
                                                    <li>
                                                        <img style="
                                                        width: 55px;
                                                    "
                                                            src="{{ asset('icon_png/piscine.png') }}" alt="piscine">
                                                        Piscine
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($property[0]->description)
                            <div class="product-single-description mt-4 title__">
                                <h4 class="mb-3">Description</h4>
                                <p>
                                    {{ $property[0]->description }}
                                </p>

                            </div>
                        @endif


                        {{-- <div class="blog-comments-form">
                            <h4 class="mb-4">Informations sur l'annonceur</h4>
                            

                            @php
                                $userType = $property[0]->user->checkType();
                                
                                $user_property_name = '';

                                switch ($userType) {
                                    case 'company':
                                        if (isset($property[0]->user->company)) {
                                            $user_property_name = $property[0]->user->company->corporate_name;
                                        } else {
                                            $user_property_name = '';
                                        }
                                        break;

                                    case 'particular':
                                        if (isset($property[0]->user->particular)) {
                                            $user_property_name = $property[0]->user->particular->first_name;
                                            $last_name = $property[0]->user->particular->last_name;

                                            if (!empty($last_name)) {
                                                $user_property_name .= ' ' . $last_name;
                                            }
                                        } else {
                                            $user_property_name = '';
                                        }
                                        break;

                                    default:
                                        $user_property_name = $property[0]->user->username;
                                        break;
                                }

                            @endphp
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
                                            {{ $user_property_name }} </label>
                                        
                                        @if ($property[0]->user->userPhone())
                                        <br>

                                            <label class="star-label"
                                                style="
                                                    color: black;
                                                    "><i
                                                    class="fa fa-phone-circle"
                                                    style="
                                                            color: #fc3131;
                                                        "></i>
                                                
                                            {{ $property[0]->user->userPhone() }}
                                            </label>
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
                                            
                                            {{ $property[0]->user->email }}</label>


                                    </div>
                                </div>

                            </div>
                            
                        </div> --}}

                        <div class="blog-comments-form">
                            <div class="product-sidebar mb-3">
                                <div class="product-single-sidebar-item">

                                    <h5 class="title">Informations sur l'annonceur</h5>



                                    <div class="product-single-author" style="overflow:auto">

                                        
                                        @php
                                            $userType = $property[0]->user->checkType();
                                            // dd($userType);

                                            $user_property_name = '';

                                            switch ($userType) {
                                                case 'company':
                                                    if (isset($property[0]->user->company)) {
                                                        $user_property_name =
                                                            $property[0]->user->company->corporate_name;
                                                    } else {
                                                        $user_property_name = '';
                                                    }
                                                    break;

                                                case 'particular':
                                                    if (isset($property[0]->user->particular)) {
                                                        $user_property_name =
                                                            $property[0]->user->particular->first_name;
                                                        $last_name = $property[0]->user->particular->last_name;

                                                        if (!empty($last_name)) {
                                                            $user_property_name .= ' ' . $last_name;
                                                        }
                                                    } else {
                                                        $user_property_name = '';
                                                    }
                                                    break;

                                                default:
                                                    $user_property_name = $property[0]->user->username;
                                                    break;
                                            }

                                        @endphp

                                        <h4><a href="#"> {{ ucfirst($user_property_name) }}
                                            </a> </h4>
                                        {{-- <span>{{ $property[0]->user->email }}</span> --}}
                                        @if ($user && $user->mobile)
                                            <div class="product-single-author-phone">
                                                <span>
                                                    <i class="far fa-phone"></i>
                                                    <span class="author-number">

                                                        {{ substr($user->mobile, 0, 5) }}XXXX</span>
                                                    <span class="author-reveal-number">{{ $user->mobile }}</span>
                                                </span>
                                                <p data-user-id="{{ $property[0]->user->id }}"
                                                    id="display-number-button">Cliquez pour afficher le numéro de téléphone
                                                </p>
                                            </div>
                                            <a href="tel:{{ $user->phone }}" class="theme-border-btn w-100 mt-4"
                                                id="call-button" data-phone="{{ $user->phone }}"
                                                data-user-id="{{ $property[0]->user->id }}"><i class="far fa-phone"></i>
                                                Appeller</a>
                                        @endif
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="blog-comments-form">
                            <div class="product-sidebar mb-3">
                            <h4 class="mb-2 title__" onclick="getmessage()" style="cursor: pointer;    text-align: center;
                            color: #fc3131;">
                                Envoyer Message <i class="fa fa-plus-circle"></i></h4>
                            <form action="{{ route('send.email.client') }}" method="POST" id="message-form"
                                style="display:none">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
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
                                        <input type="hidden" name="type" value="property">
                                        <input type="hidden" name="property_id" value="{{ $property[0]->id }}">

                                        <button type="submit" class="theme-btn">Envoyer <i
                                                class="far fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        </div>


                        {{-- pub --}}

                        {{-- endpub --}}
                        @if (count($propertyRelated) > 0)
                            <div class="product-single-related mt-5">
                                <h4 class="mb-4">Annonces Similaires</h4>
                                <div class="row">
                                    {{-- <div class="col-10"> --}}

                                    @foreach ($propertyRelated as $item)
                                    @if (!$item->user == null)
                                        <div class="col-md-6 col-lg-4">
                                            @include('includes.item_property')
                                        </div>
                                    @endif
                                    @endforeach
                                    {{-- </div> --}}

                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- --------------------- user info----------------- --}}

                <div class="col-lg-3">
                    <div class="product-sidebar mb-3">
                        <div class="product-single-sidebar-item">
                            {{-- @if ($property[0]->operation->name === 'location')
                                <h5 class="title">Information sur le locataire</h5>
                            @else
                                <h5 class="title">Information sur le vendeur</h5>
                            @endif --}}

                            <h5 class="title">PUBLICITÉS</h5>
                            <div class="blog-item-img" style="overflow:auto">
                                @foreach ($ads as $ad)
                                    <a href="{{ $ad->url ? route('ad.click', ['id' => $ad->id]) : '#' }}"
                                        class="mb-4" title="{{ ucfirst($ad->description) }}">
                                        <img src="{{ asset($ad ? 'uploads/ads/' . $ad->alt : 'assets/img/account/user0.jpg') }} "
                                            alt="">
                                    </a>
                                @endforeach
                            </div>

                            {{-- <div class="product-single-author" style="overflow:auto">

                                <img src="{{ asset($user_logo ? 'uploads/user_logos/' . $user_logo->alt : 'assets/img/account/user0.jpg') }} "
                                    alt="">


                                @php
                                    $userType = $property[0]->user->checkType();
                                    $user_property_name = '';

                                    switch ($userType) {
                                        case 'company':
                                            if (isset($property[0]->user->company)) {
                                                $user_property_name = $property[0]->user->company->corporate_name;
                                            } else {
                                                $user_property_name = '';
                                            }
                                            break;

                                        case 'particular':
                                            if (isset($property[0]->user->particular)) {
                                                $user_property_name = $property[0]->user->particular->first_name;
                                                $last_name = $property[0]->user->particular->last_name;

                                                if (!empty($last_name)) {
                                                    $user_property_name .= ' ' . $last_name;
                                                }
                                            } else {
                                                $user_property_name = '';
                                            }
                                            break;

                                        default:
                                            $user_property_name = $property[0]->user->username;
                                            break;
                                    }

                                @endphp


                                <h4><a href="#"> {{ ucfirst($user_property_name) }}
                                    </a></h4>
                                @if ($user && $user->phone)
                                    <div class="product-single-author-phone">
                                        <span>
                                            <i class="far fa-phone"></i>
                                            <span class="author-number">

                                                {{ substr($user->phone, 0, 6) }}XXXX</span>
                                            <span class="author-reveal-number">{{ $user->phone }}</span>
                                        </span>
                                        <p>Cliquez pour afficher le numéro de téléphone</p>
                                    </div>
                                    <a href="tel:{{ $user->phone }}" class="theme-border-btn w-100 mt-4"><i
                                            class="far fa-phone"></i>
                                        Appeller</a>
                                @endif
                            </div> --}}

                        </div>
                    </div>
                </div>
                {{--  --}}

            </div>
        </div>
    </div>
    <form id="call-action-form" method="POST" action="{{ route('save_statistique') }}" style="display: none;">
        @csrf
        <input type="hidden" name="user_id" id="user-id-input" value="{{ $property[0]->user->id }}">
        <input type="hidden" name="action_type" value="call">
        <input type="hidden" name="phone" id="phone-input">
    </form>
    {{-- statistique --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#call-button').on('click', function(e) {
                e.preventDefault(); // Prevent default link action

                // Get the data attributes
                var userId = $(this).data('user-id');
                var phone = $(this).data('phone');

                // Set the form inputs
                $('#user-id-input').val(userId);
                $('#phone-input').val(phone);

                // Submit the form using AJAX
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
            // $('#call-button').on('click', function(e) {
            //     e.preventDefault();

            //     $('#call-action-form').submit();
            // });

            // $('#call-button').on('click', function(e) {
            //     e.preventDefault();

            //     var userId = $(this).data('user-id');
            //     var phone = $(this).data('phone');

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
            //                 // setTimeout(function() {
            //                 //     window.location.href = 'tel:' + phone;
            //                 // }, 100);
            //             }
            //         }
            //     });
            // });

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
    </script>


    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

    <!-- Initialize the SDK with your App ID -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '443345395094185',
                xfbml: true,
                version: 'v12.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function shareOnFacebook() {
            var url = encodeURIComponent('{{ url()->current() }}');
            var shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    </script>
@endsection
