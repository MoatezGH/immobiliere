@extends('layouts.app')
@section('meta')
    <!-- Open Graph meta tags -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $service[0]->title }}">
    <meta property="og:description" content="{{ $service[0]->description }}">
    <meta property="og:image" content="{{ $service[0]->get_meta_image() }}">
    <meta property="og:type" content="website" />

    @if (config('services.facebook.app_id'))
        <meta property="fb:app_id" content="{{ config('services.facebook.app_id') }}">
    @endif
@endsection


@section('pageTitle')
    {{ $service[0]->title }}
@endsection
@section('content')
    {{-- {{ dd($service[0]->user_id) }} --}}

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




    {{-- {{ dd($user) }} --}}
    @include('includes.slider')

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
                                <h3 class="title__">{{ strtoupper($service[0]->title) }}</h3>
                                <p><img src="{{ asset('icon_png/calendar.png') }}" alt="" style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        Publié le {{ $service[0]->created_at->format('d/m/y') }}</p>
                            </div>
                            <div class="product-single-btn">



                                <a href="#"
                                    onclick="shareOnFacebook('{{ $service[0]->title }}','{{ $service[0]->get_meta_image() }}','{{ $service[0]->slug }}')"><i
                                        class="far fa-share-alt"></i></a>


                            </div>
                        </div>
                        <div class="product-single-slider">
                            <div class="item-gallery">
                                <div class="flexslider-thumbnails">
                                    <ul class="slides">
                                        @if (count($service[0]->pictures) > 0)
                                            @foreach ($service[0]->pictures as $item)
                                                @php

                                                    $imagePath = 'uploads/service/multi_images/' . $item->picture_path;

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
                                            @if ($service[0]->mainPicture)
                                                <li
                                                    data-thumb="{{ asset('uploads/service/main_picture/' . $service[0]->mainPicture->picture_path) }}">
                                                    <img src="{{ asset('uploads/service/main_picture/' . $service[0]->mainPicture->picture_path) }}"
                                                        alt="#" class="img_sl">
                                                </li>
                                            @else
                                                <li data-thumb="{{ asset('assets/img/product/slider-1.jpg') }}">
                                                    <img src="{{ asset('assets/img/product/slider-1.jpg') }}"
                                                        alt="#" class="img_sl">
                                                </li>
                                            @endif
                                        @endif


                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="product-single-price" style="color:#fc3131">
                            {{-- {{ $service[0]->price }} --}}
                            {{-- {{ number_format($property[0]->price / 1) }} --}}
                            {{-- DT --}}

                        </div>
                        <img src="{{ asset('icon_png/ref.png') }}" alt="" style="width:45px">
                        <span style="color: #fc3131;">
                            REF: {{ strtoupper($service[0]->ref) }}
                        </span>
                        <div class="product-single-moreinfo">
                            <ul>
                                <li><img src="{{ asset('icon_png/type.png') }}" alt="" style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    ">{{ strtoupper($service[0]->category->name) }}</span>
                                </li>


                                <li><img src="{{ asset('icon_png/location.png') }}" alt="" style="width:45px">
                                    <span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        {{ $service[0]->city->name }}
                                    </span>


                                </li>
                                <li><img src="{{ asset('icon_png/eyes.png') }}" alt="" style="width:45px"><span
                                        style="
                                        margin-left: -5px;
                                    ">
                                        {{ $service[0]->count_views }} Vues
                                </li>
                            </ul>
                        </div>

                        <div class="row">
                            <div class="product-single-description mt-4 ">
                                <h4 class="mb-3">Type d'annonceur</h4>
                                <p>
                                    {{ $type_annonceur }}
                                </p>

                            </div>

                            <div class="product-single-description mt-4 ">
                                <h4 class="mb-3">Paiement</h4>
                                <p>
                                    {{ $payement }}
                                </p>

                            </div>


                        </div>
                        <div class="row">

                            @if ($service[0]->work_zone)
                                <div class="product-single-description mt-4 ">
                                    <h4 class="mb-3">Zone de travaille</h4>
                                    <p>
                                        {{ ucfirst($service[0]->work_zone) }}
                                    </p>

                                </div>
                            @endif
                            @if ($service[0]->service)
                                <div class="product-single-description mt-4 ">
                                    <h4 class="mb-3">Service</h4>
                                    <p>
                                        {{ ucfirst($service[0]->service) }}
                                    </p>

                                </div>
                            @endif


                            <div class="product-single-description mt-4 ">
                                <h4 class="mb-3">Type</h4>
                                <p>
                                    {{ $type }}
                                </p>

                            </div>
                        </div>

                        @if ($service[0]->description)
                            <div class="product-single-description mt-4 title__">
                                <h4 class="mb-3">Description</h4>
                                <p>
                                    {{ $service[0]->description }}
                                </p>

                            </div>
                        @endif


                        <div class="blog-comments-form">
                            <div class="product-sidebar mb-3">
                                <div class="product-single-sidebar-item">

                                    <h5 class="title">Informations sur l'annonceur</h5>



                                    <div class="product-single-author" style="overflow:auto">

                                        <img src="{{ asset($service[0]->user->logo ? 'uploads/user_service_logos/' . $service[0]->user->logo : 'assets/img/account/user0.jpg') }} "
                                            alt="">

                                        {{-- {{ dd($service[0]->user) }} --}}
                                        <h4><a href="#"> {{ ucfirst($service[0]->user->full_name) }}
                                            </a>
                                            @if (isset($service[0]->user->fb_link) && !empty($service[0]->user->fb_link))
                                                <a href="{{ $service[0]->user->fb_link }}" class="w-100 mt-4"><img
                                                        src="{{ asset('icon_png/facebook.png') }}" alt=""
                                                        style="
                                                        width: 25px;
                                                    ">
                                                </a>
                                            @endif
                                        </h4>

                                        @if ($service[0]->user->phone)
                                            <div class="product-single-author-phone">
                                                <span>
                                                    <i class="far fa-phone"></i>
                                                    <span class="author-number">
                                                        {{-- {{ dd($user) }} --}}
                                                        {{ substr($service[0]->user->phone, 0, 5) }}XXXX</span>
                                                    <span
                                                        class="author-reveal-number">{{ $service[0]->user->phone }}</span>
                                                </span>
                                                <p>Cliquez pour afficher le numéro de téléphone</p>
                                            </div>
                                            <a href="tel:{{ $service[0]->user->phone }}"
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
                                                    placeholder="Message*">Je suis intéressé par cette service [REF: {{ $service[0]->ref }} ] et j'aimerais avoir plus de détails.
                                                </textarea>

                                            </div>
                                            @include('message_session.error_field_message', [
                                                'fieldName' => 'message',
                                            ])
                                            <input type="hidden" name="type" value="service">
                                            <input type="hidden" name="property_id" value="{{ $service[0]->id }}">

                                            <button type="submit" class="theme-btn">Envoyer <i
                                                    class="far fa-paper-plane"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>



                        {{-- pub --}}

                        {{-- endpub --}}
                        @if (count($serviceRelated) > 0)
                            <div class="product-single-related mt-5">
                                <h4 class="mb-4">Annonces Similaires</h4>
                                <div class="row">


                                    @foreach ($serviceRelated as $item)
                                        <div class="col-md-6 col-lg-4">
                                            @include('includes.service.item_service')

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

        // function shareOnFacebook(t, i, id) {
        //     // console.log(i)

        //     FB.ui({
        //         method: 'share',
        //         href: 'http://les-annonces.com.tn/propertie_/' + id,
        //         quote: t,
        //         picture: i,


        //     }, function(response) {
        //         console.log(response)
        //     });
        // }

        function shareOnFacebook() {
            var url = encodeURIComponent('{{ url()->current() }}');
            var shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    </script>
@endsection
