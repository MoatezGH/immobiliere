@extends('layouts.app')
@section('meta')
    <!-- Open Graph meta tags -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $classified[0]->title }}">
    <meta property="og:description" content="{{ $classified[0]->description }}">
    <meta property="og:image" content="{{ $classified[0]->get_meta_image() }}">
    <meta property="og:type" content="website" />

    @if (config('services.facebook.app_id'))
        <meta property="fb:app_id" content="{{ config('services.facebook.app_id') }}">
    @endif
@endsection


@section('pageTitle')
    {{ $classified[0]->title }}
@endsection
@section('content')
    {{-- {{ dd($classified[0]->get_meta_image()) }} --}}

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

@include("includes.slider")

    {{-- {{ dd($property[0]->main_picture->alt) }} --}}


    {{-- {{ dd($user) }} --}}

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
                                <h3 class="title__">{{ strtoupper($classified[0]->title) }}</h3>
                                <p><img src="{{ asset('icon_png/calendar.png') }}" alt="" style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        Publié le {{ $classified[0]->created_at->format('d/m/y') }}</p>
                            </div>
                            <div class="product-single-btn">

                                {{-- @if (Auth::check())
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
                                    <a onclick="goLogin()" class="favorite-button" href="#"><i
                                            class="far fa-heart"></i></a>
                                    <form id="goLogin" style="display:none" action="{{ route('login') }}" method="GET">
                                        @csrf

                                    </form>
                                    <!-- Display login link or button -->
                                @endif --}}

                                <a href="#"
                                    onclick="shareOnFacebook('{{ $classified[0]->title }}','{{ $classified[0]->get_meta_image() }}','{{ $classified[0]->slug }}')"><i
                                        class="far fa-share-alt"></i></a>
                                {{-- <a href="#"><i class="far fa-flag"></i></a> --}}
                                {{-- REF:
                                <span style="color: #fc3131;">
                                    {{ strtoupper( $classified[0]->ref) }}
                                </span> --}}

                            </div>
                        </div>
                        <div class="product-single-slider">
                            <div class="item-gallery">
                                <div class="flexslider-thumbnails">
                                    <ul class="slides">
                                        @if (count($classified[0]->pictures) > 0)
                                            @foreach ($classified[0]->pictures as $item)
                                                @php

                                                    $imagePath =
                                                        'uploads/classified/multi_images/' . $item->picture_path;

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
                                                    <img src="{{ $imageSrc }}" alt="#" class="img_sl">
                                                </li>
                                            @endforeach
                                        @else
                                            <li
                                                data-thumb="{{ asset('uploads/classified/main_picture/' . $classified[0]->mainPicture->picture_path) }}">
                                                <img src="{{ asset('uploads/classified/main_picture/' . $classified[0]->mainPicture->picture_path) }}"
                                                    alt="#" class="img_sl">
                                            </li>
                                        @endif


                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="product-single-price" style="color:#fc3131">
                            {{ $classified[0]->price }}
                            {{-- {{ number_format($property[0]->price / 1) }} --}}
                            DT

                        </div>
                        <img src="{{ asset('icon_png/ref.png') }}" alt="" style="width:45px">
                        <span style="color: #fc3131;">
                            {{ strtoupper($classified[0]->ref) }}
                        </span>
                        <div class="product-single-moreinfo">
                            <ul>
                                <li><img src="{{ asset('icon_png/type.png') }}" alt="" style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    ">{{ strtoupper($classified[0]->category->name) }}</span>
                                </li>
                                {{-- <li><img src="{{ asset('icon_png/operation.png') }}" alt=""
                                        style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    "> --}}
                                {{-- {{ strtoupper($property[0]->operation->name) }}</li> --}}

                                <li><img src="{{ asset('icon_png/location.png') }}" alt="" style="width:45px">
                                    <span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        {{ $classified[0]->city->name }},
                                        {{ $classified[0]->area->name }}
                                    </span>


                                </li>
                                <li><img src="{{ asset('icon_png/eyes.png') }}" alt="" style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        {{ $classified[0]->count_views }} Vues
                                </li>
                            </ul>
                        </div>
                        <div class="product-single-description mt-4">
                            <h4 class="mb-3">État</h4>
                            <p>
                                {{ $condition }}
                            </p>

                        </div>

                        <div class="product-single-description mt-4">
                            <h4 class="mb-3">Type</h4>
                            <p>
                                {{ $type }}
                            </p>

                        </div>
                        @if ($classified[0]->description)
                            <div class="product-single-description mt-4 title__">
                                <h4 class="mb-3">Description</h4>
                                <p>
                                    {{ $classified[0]->description }}
                                </p>

                            </div>
                        @endif


                        <div class="blog-comments-form">
                            <div class="product-sidebar mb-3">
                                <div class="product-single-sidebar-item">

                                    <h5 class="title">Informations sur l'annonceur</h5>



                                    <div class="product-single-author" style="overflow:auto">

                                        <img src="{{ asset($classified[0]->user->logo ? 'uploads/user_classifed_logos/' . $classified[0]->user->logo : 'assets/img/account/user0.jpg') }} "
                                        alt="">


                                        <h4><a href="#"> {{ ucfirst($classified[0]->user->full_name) }}
                                            </a></h4>

                                        @if ($classified[0]->user->phone)
                                            <div class="product-single-author-phone">
                                                <span>
                                                    <i class="far fa-phone"></i>
                                                    <span class="author-number">
                                                        {{-- {{ dd($user) }} --}}
                                                        {{ substr($classified[0]->user->phone, 0, 5) }}XXXX</span>
                                                    <span
                                                        class="author-reveal-number">{{ $classified[0]->user->phone }}</span>
                                                </span>
                                                <p>Cliquez pour afficher le numéro de téléphone</p>
                                            </div>
                                            <a href="tel:{{ $classified[0]->user->phone }}"
                                                class="theme-border-btn w-100 mt-4"><i class="far fa-phone"></i>
                                                Appeller</a>
                                        @endif
                                    </div>




                                    {{-- pub --}}

                                    {{-- endpub --}}

                                </div>
                            </div>
                        </div>

                        <div class="blog-comments-form">
                            <div class="product-sidebar mb-3">

                            <h4 class="mb-2 title__" onclick="getmessage()" style="cursor: pointer;text-align: center;
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
                                                placeholder="Message*">Je suis intéressé par cette annonce [REF: {{ $classified[0]->ref }} ] et j'aimerais avoir plus de détails.
                                                </textarea>

                                        </div>
                                        @include('message_session.error_field_message', [
                                            'fieldName' => 'message',
                                        ])
                                        <input type="hidden" name="type" value="classified">
                                        <input type="hidden" name="property_id" value="{{ $classified[0]->id }}">

                                        <button type="submit" class="theme-btn">Envoyer <i
                                                class="far fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                        {{-- pub --}}

                        {{-- endpub --}}
                        @if (count($classifiedRelated) > 0)
                            <div class="product-single-related mt-5">
                                <h4 class="mb-4">Annonces Similaires</h4>
                                <div class="row">
                                    

                                    @foreach ($classifiedRelated as $item)
                                        <div class="col-md-6 col-lg-4">
                                            @include('includes.classified.item_classified')

                                        </div>
                                    @endforeach
                                    

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

        function shareOnFacebook(t, i, id) {
            // console.log(i)

            FB.ui({
                method: 'share',
                href: 'http://les-annonces.com.tn/propertie_/' + id,
                quote: t,
                picture: i,


            }, function(response) {
                console.log(response)
            });
        }
    </script>
@endsection
