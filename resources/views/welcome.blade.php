<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Immobiliere.tn est le site des petites annonces leader en Tunisie. Annonces immobilières. Annonces Direct Promoteurs. Agences immobilières. Les stores. Annonces ventes diverses. Annonce des services. Louez, achetez et vendez grâce à la plus large offre en Tunisie">


    <meta name="keywords" content="site immobilier, Tunisie immobilier, annonce immobilier Tunisie, appartement a vendre,terrain a vendre,Tunisie annonce immobilier, direct promoteurs immobiliers, immobilier neuf, agences immobilière Tunisie, vente immobilière Tunisie, annonces ventes diverses, vide grenier, annonces professionnels, annonces des services divers, Annonces vente particulier">
<link href="https://immobiliere.tn/" rel="canonical" />    
<meta property="og:url" content="https://immobiliere.tn/" />
    <title>Immobiliere TN | Trouvez votre bien immobilier en Tunisie</title>



<meta property="og:title" content="Immobiliere tn - Meilleur site immobilier " />

<meta property="og:description" content="immobilier tn est le meilleur site immobilier,services et ventes diverses en tunisie.Louez, achetez et vendez grâce à la plus large offre immobilière en Tunisie." />
   
<meta property="og:site_name" content="Immobiliere tn" />
<meta property="og:type" content="website">
 <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon.png') }}">

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all-fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "pub-8182502623916154",
        enable_page_level_ads: true
      });
    </script>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-WWLJCKV3WL">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-WWLJCKV3WL');
</script>
    @stack('stylesheets')

</head>
<style>
    @media only screen and (max-width: 600px) {
        .hero-background {
            background-size: contain !important;
            margin-top: -320px !important;
        }

        .owl-nav {
            display: none;
        }

        .search-area {
            margin-top: -420px;
        }

    }

    .hero-background {
        height: 1000px;
    }
</style>

<body class="home-4">
<!-- <div class="preloader">
        <div class="loader">
            <div class="loader-dot"></div>
            <div class="loader-dot dot2"></div>
            <div class="loader-dot dot3"></div>
            <div class="loader-dot dot4"></div>
            <div class="loader-dot dot5"></div>
        </div>
    </div> -->


    @include('includes.header')
    <!-- header area end -->

    {{-- --}}
    {{-- {{ dd($sliders) }} --}}
    <main class="main ">
    
        <!-- hero area -->
        <div class="hero-section ">
            <div class="hero-slider owl-carousel owl-theme">

                @foreach ($sliders as $item)
                <div class="hero-single hero-background slider-item" style="background:url({{ asset('uploads/sliders/' . $item->alt) }});" data-id="{{ $item->id }}" data-url="{{ $item->url ? $item->url : '#' }}">

                </div>
                @endforeach


            </div>
        </div>
        <!-- hero area end -->


        <!-- search area -->
        <div class="search-area">
            <div class="container">
                <div class="search-wrapper">
                    <div class="search-form">
                        <form id="searchForm" method="GET" action="#">

                            <!-- @csrf -->
                            <div class="row align-items-center mb-2">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-group-icon">
                                            <select class="select" name="category_id"  >
                                                <option value="" disabled selected>Catégorie</option>
                                                @foreach ($categories as $value)
                                                <option value="{{ $value->name }}">
                                                    {{ ucfirst($value->name) }}
                                                </option>
                                                @endforeach


                                            </select>
                                            <i class="far fa-bars-sort"></i>
                                        </div>
                                        <small class="text-danger" id="category_error" style="display:none">Veuillez sélectionner une catégorie</small>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4">
                                    <div class="form-group">
                                    
                                        <div class="form-group-icon">
                                            <select class="select" name="operation_id"  >
                                                <option value="" disabled selected>Opération</option>
                                                @foreach ($operation as $value)
                                                <option value="{{ $value->name }}" >
                                                    {{ ucfirst($value->name) }}
                                                </option>
                                                @endforeach


                                            </select>
                                            <i class="far fa-bars-sort"></i>
                                        </div>
                                    <small class="text-danger" id="operation_error" style="display:none">Veuillez sélectionner une opération de propriété</small>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-group-icon">
                                            <input type="text" class="form-control" placeholder="Référence" name="reference">
                                            <i class="far fa-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                


                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-group-icon">
                                            <select class="select" name="city_id" id="citySelect">
                                                <option value="">Ville</option>
                                                @foreach ($cities as $value)
                                                <option value="{{ $value->slug }}" {{ old('city_id') == $item->id ? 'checked' : '' }}>
                                                    {{ ucfirst($value->name) }}
                                                </option>
                                                @endforeach


                                            </select>
                                            <i class="far fa-location-dot"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group" id="area_div">
                                        <div class="form-group-icon">
                                            <select class="select" name="area_id" id="areaSelect">
                                                <option value="">Région</option>



                                            </select>
                                            <i class="far fa-location-dot"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2">
                                    <button type="submit" class="theme-btn"><span class="far fa-search"></span>Chercher</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>

                    <div class="search-keyword">
                        <span>Mots-clés tendance:</span>
                        <a href="{{route('index_classified_front')}}">Ventes Diverses</a>
                        <a href="{{route('index_service_front')}}">Services</a>
                        <a href="{{ route('all_properties_promoteur') }}">Direct
                            Promoteurs</a>
                        <a href="{{ url('/cherche/appartement-vente') }}">A Vendre</a>
                        <a href="{{ url('/cherche/appartement-location') }}">A Louer</a>
                        <!-- <a href="#">Furnitures</a> -->
                    </div>

                </div>
            </div>
        </div>
        <!-- search area end -->






        {{-- end_promoteur --}}
        <!-- product area -->
        <div class="product-area bg py-120" style="
                    padding-bottom: 10px !important;
                ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">ANNONCES PREMIUM</span>
                            <h1 class="site-title">Explorez nos annonces premium</h1>
                            <p>Prêt pour votre vision. Investissez dans votre avenir.
                            </p>
                        </div>
                    </div>
                </div>
                @if (count($properties) > 0)
                <div class="row">

                    @foreach ($properties as $item)
                    {{-- {{ dd($item) }} --}}
                    @if (!$item->property) @continue @endif
                    {{-- {{ dd($item->property->main_picture->alt) }} --}}
                    <div class="col-md-6 col-lg-4">
                        {{-- @if ($item->type__ == 'property') --}}
                        @include('includes.premium.item_property')

                        {{-- @endif --}}
                    </div>
                    @endforeach


                </div>
                <div class="row justify-content-center ">
                    <div class="col-md-6 text-center">
                        <a href="https://immobiliere.tn/cherche/" class="theme-border-btn">Voir tous<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                @endif
                {{-- ----------------------- premium ------------------ --}}
                @if (count($properties_prom_pre) > 0)
                <div class="row mt-3">
                    <div class="col-lg-7 mx-auto">
                        <div class="site-heading text-center">

                            <h2 class="site-title">Annonces Direct Promoteurs</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($properties_prom_pre as $item)
                    @if (!$item->propertypromoteur) @continue @endif
                    @if(!$item->propertypromoteur->user) @continue @endif

                    <div class="col-md-6 col-lg-4">
                        {{-- @if ($item->type__ == 'property') --}}
                        @include('includes.premium.item_promoteur_property')

                        {{-- @endif --}}
                    </div>
                    @endforeach


                </div>

                <div class="row justify-content-center ">
                    <div class="col-md-6 text-center">
                        <a href="{{ route('all_properties_promoteur') }}" class="theme-border-btn">Voir tous<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                @endif

                @if (count($classifieds) > 0)
                <div class="row mt-3">
                    <div class="col-lg-7 mx-auto">
                        <div class="site-heading text-center">

                            <h2 class="site-title">Annonces Débarras</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($classifieds as $item)
                    @if (!$item->classified) @continue @endif

                    <div class="col-md-6 col-lg-4">
                        {{-- @if ($item->type__ == 'property') --}}
                        @include('includes.premium.item_classified')

                        {{-- @endif --}}
                    </div>
                    @endforeach


                </div>

                <div class="row justify-content-center ">
                    <div class="col-md-6 text-center">
                        <a href="{{ route('index_classified_front') }}" class="theme-border-btn">Voir tous<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                @endif


                @if (count($services) > 0)
                <div class="row mt-3">
                    <div class="col-lg-7 mx-auto">
                        <div class="site-heading text-center">

                            <h2 class="site-title">Annonces Services</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($services as $item)
                    @if (!$item->service) @continue @endif
                    @if ($item->service->status==0) @continue @endif


                    <div class="col-md-6 col-lg-4">
                        {{-- @if ($item->type__ == 'property') --}}
                        @include('includes.premium.item_service')

                        {{-- @endif --}}
                    </div>
                    @endforeach


                </div>

                <div class="row justify-content-center ">
                    <div class="col-md-6 text-center">
                        <a href="{{ route('index_service_front') }}" class="theme-border-btn">Voir tous<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!-- product area end -->



        <!-- service area -->
        <div class="service-area pt-120 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Services</span>
                            {{-- <h2 class="site-title">Découvrez nos services de publicité et de consulting</h2> --}}
                            <p>Découvrez nos services de publicité et de consulting.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                @foreach ($serviceWeb as $item)

                    <div class="col-md-6 col-lg-4">
                        <div class="service-item">
                            <div class="service-icon">
                                <img src="{{ asset('uploads/serviceWeb/'.$item->imageUrl) }}" alt="{{ $item->title }}" style="max-width: 100px !important;">
                            </div>
                            <div class="service-content">
                                <h4>{{ ucfirst($item->title) }}</h4>
                                <p>{{ $item->description }}</p>
<a href="{{$item->lien}}" class="theme-border-btn">En savoir plus<i class="fas fa-arrow-right"></i></a>
                                
                            </div>
                        </div>

                    </div>
                    @endforeach

                    <!-- <div class="col-md-6 col-lg-4">
                        <div class="service-item">
                            <div class="service-icon">
                                <img src="{{ asset('service_icon/2.png') }}" alt="" style="width:71px;">
                            </div>
                            <div class="service-content">
                                <h4>Les Annonces Premium</h4>
                                <p>Visible à chaque connexion sur le site.</p>
                                <a href="#" class="theme-border-btn">En savoir plus<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="service-item">
                            <div class="service-icon">
                                <img src="{{ asset('service_icon/3.png') }}" alt="" style="width: 140px;">
                            </div>
                            <div class="service-content">
                                <h4>Les Affiches Plien écran</h4>
                                <p>Visible à chaque connexion sur le site. Cliquable et dirigent vers l'adresse de votre
                                    choix.</p>
                                <a href="#" class="theme-border-btn">En savoir plus<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="service-item">
                            <div class="service-icon">
                                <img src="{{ asset('service_icon/4.png') }}" alt="" style="width: 140px;">
                            </div>
                            <div class="service-content">
                                <h4>Les Vidéos</h4>
                                <p>3 mn maximum, visible sur toutes les pages fil d'annonces est aussi détails
                                    d'annonces.</p>
                                <a href="#" class="theme-border-btn">En savoir plus<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="service-item">
                            <div class="service-icon">
                                <img src="{{ asset('service_icon/5.png') }}" alt="" style="width: 202px;">
                            </div>
                            <div class="service-content">
                                <h4>Les Banniéres Pavés</h4>
                                <p>Visible sur toutes les pages fil d'annonces est aussi détails d'annonces. Cliquable
                                    et dirigent vers l'adresse de votre choix.</p>
                                <a href="#" class="theme-border-btn">En savoir plus<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="service-item">
                            <div class="service-icon">
                                <img src="{{ asset('service_icon/6.png') }}" alt="" style="width: 51px;">
                            </div>
                            <div class="service-content">
                                <h4>Campagnes Publicitaires</h4>
                                <p>Campagne sur mesure.</p>
                                <a href="#" class="theme-border-btn">En savoir plus<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- blog-area -->
        <div class="blog-area pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">NOS PARTENAIRES</span>
                            <h2 class="site-title">Découvrez nos partenaires</h2>
                            <p>Bénéficiez de l'expertise de nos partenaires pour tous vos besoins immobiliers
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($partenaires as $item)
                    {{-- {{ dd($partenaires) }} --}}
                    <div class="col-md-6 col-lg-3">
                        <div class="blog-item">
                            <div class="blog-item-img">
                                <a href="{{route('incrementViewCountPartenaire',$item->id)}}">
                                    <img src="{{ asset('uploads/partenaire/' . $item['image_url']) }}" alt="{{ $item['description'] }}">
                                </a>
                            </div>
                            <div class="blog-item-info">

                                <h4 class="blog-title">
                                    <a href="{{route('incrementViewCountPartenaire',$item->id)}}">{{ $item['description'] }}</a>
                                </h4>
                                {{-- <a class="theme-btn" href="#">Lire la suite<i
                                            class="fas fa-arrow-right"></i></a> --}}
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- blog-area end -->

        
        <!-- partner area -->
        <div class="partner-area bg pt-50 pb-50">
            <div class="site-heading text-center">
                <span class="site-title-tagline">LES STORES</span>
                <h2 class="site-title">Visiter les stores des nos partenaires</h2>
                {{-- <p>Bénéficiez de l'expertise de nos partenaires pour tous vos besoins immobiliers
                            </p> --}}
            </div>
            <div class="container">

                {{-- <span class="site-title-tagline">NOS STORES</span> --}}
                <div class="partner-wrapper partner-slider owl-carousel owl-theme">
                    @foreach ($storesItems as $item)
                    <a href="{{ route('all_product_store', $item->slug) }}" title="{{ $item->store_name }}">
                        @if ($item->logo)
                        <img src="{{ asset('uploads/store_logos/' . $item->logo) }}" style="    width: 110px;
                            height: 90px;
                            padding: 0px;
                            margin: 0 8px;
                            border-radius: 5px;
                            border: 1px lightgrey solid;" alt="{{ $item->store_name }}">
                        @else
                        <img src="{{ asset('assets/img/product/01.jpg') }}" style="    width: 110px;
                            height: 90px;
                            padding: 0px;
                            margin: 0 8px;
                            border-radius: 5px;
                            border: 1px lightgrey solid;" alt="{{ $item->store_name }}">
                        @endif

                    </a>
                    @endforeach


                </div>
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6 text-center">
                        <a href="{{ route('stores') }}" class="theme-border-btn">Voir tous<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

            </div>

        </div>
        {{-- @endif --}}
        <!-- partner area end -->


    </main>



    <!-- footer area -->
    @include('includes.footer')
    <!-- footer area end -->



    <!-- scroll-top -->
    <a href="#" id="scroll-top"><i class="far fa-angle-up"></i></a>
    <!-- scroll-top end -->


    <!-- js -->
    <!-- js -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter-up.js') }}"></script>
    <script src="{{ asset('assets/js/masonry.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/js.js') }}"></script>

    @stack('scripts')
<script>
        $(document).ready(function() {
            // Handle city selection change
            $('#citySelect').on('change', function() {
                var cityId = $(this).val();
                var areaDiv = $("#area_div");
                var ulElement = areaDiv.find("ul.list");
                var current = areaDiv.find("span.current");

                // $(ulElement).attr('id', 'test');
                // console.log(ulElement)
                // Make an AJAX request to fetch areas based on the selected city
                $.ajax({
                    url: '/get-areas/' + cityId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Clear existing options
                        $('#areaSelect').empty();
                        $(current).empty();

                        $('#areaSelect').append(
                            '<option value="">Choissir une région</option>');
                        $(ulElement).empty();
                        $(ulElement).append(
                            '<li data-value="" class="option selected">Choissir une région</li>'
                        )


                        // Populate areas dropdown with new options
                        $.each(data, function(key, value) {
                            $('#areaSelect').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });

                        $.each(data, function(key, value) {
                            $(ulElement).append('<li  data-value="' + value.id +
                                '" class="option">' + value.name + ' </li>');
                        });

                        // <li data-value="" class="option selected">Choissir une ville</li>
                        // $('#areaSelect').addClass('select');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            ///slider
            $('.slider-item').on('click', function(e) {
                e.preventDefault();
                console.log('first')
                var adId = $(this).data('id');
                var adUrl = $(this).data('url');

                if (adUrl === '#') {
                    return;
                }

                $.ajax({
                    url: "{{ route('slider.click') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: adId
                    },
                    success: function(response) {
                        // window.location.href = response.url;
                        if (response.url) {
                            window.open(response.url, '_blank');
                        } else {
                            console.log('An error occurred while processing your request.');
                        }
                    },
                    error: function(xhr) {
                        console.error('An error occurred:', xhr.responseText);
                    }
                });
            });
        });
    </script>
    {{-- @notifyJs --}}

</body>

</html>