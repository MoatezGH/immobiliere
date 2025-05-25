<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @yield('meta')
    
    @include('includes.meta.index')


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
    <link rel="stylesheet" href="{{ asset('assets/css/flex-slider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    @stack('stylesheets')


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
</head>

<body class="home-4">
<style>
        @media only screen and (max-width: 600px) {
        .product-area {
            padding-top: 0px !important;
        }
.product-single {
padding-top:0px !important;}
        }
    }
    </style>
    <!-- preloader -->
    <div class="preloader">
        <div class="loader">
            <div class="loader-dot"></div>
            <div class="loader-dot dot2"></div>
            <div class="loader-dot dot3"></div>
            <div class="loader-dot dot4"></div>
            <div class="loader-dot dot5"></div>
        </div>
    </div>
    <!-- preloader end -->


    <!-- header area -->
    @include('includes.header')
    <!-- header area end -->



    <main class="main">
<style>

.title__{
    border: 2px solid #fc3131;
    padding: 8px;
    border-radius: 10px;
}
</style>

        @yield('content')

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
    <script src="{{ asset('assets/js/flex-slider.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/js.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Handle city selection change
            $('#citySelect').on('change', function() {
                //var cityId = $(this).val();
var cityId = $(this).find(':selected').data('id');
                var areaDiv = $("#area_div");
                var ulElement = areaDiv.find("ul.list");
                var current = areaDiv.find("span.current");
console.log(cityId)
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
    @stack('scripts')

    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v20.0&appId=443345395094185" nonce="UuHmKyiJ">
    </script>
    {{-- @notifyJs --}}

    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>


</body>

</html>
