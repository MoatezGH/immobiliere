<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    {{-- @csrf --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Immobiliere-@yield('pageTitle')</title>

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
    {{-- @notifyCss --}}
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    @stack('stylesheets')
</head>

<body class="home-4">

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
        {{-- <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
            <div class="container">
                <h2 class="breadcrumb-title">@yield('sectionTitle')</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="#">Tableau de bord</a></li>
                    <li class="active">@yield('sectionTitle')</li>
                </ul>
            </div>
        </div> --}}
        @include("includes.image_page")
        <div class="user-profile py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        
                        @if (auth()->user()->is_admin == 1)
                        
                            @include('includes.side_bar_admin_dashboard')
                        @else
                            @include('includes.side_bar_dashboard')
                        @endif
                        

                    </div>
                    <div class="col-lg-9">
                        @yield('content')

                    </div>
                </div>
            </div>
        </div>

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
    <script>
        $(document).ready(function() {
            // Handle city selection change
            $('#citySelect').on('change', function() {
                var cityId = $(this).val();
                var areaDiv = $("#area_div");
                var current = areaDiv.find("span.current");

                var ulElement = areaDiv.find("ul.list");
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
        });
    </script>
    @stack('scripts')
    {{-- @notifyJs --}}

</body>

</html>
