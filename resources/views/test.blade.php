<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- title -->
    <title>Clasad - Classified Ads and Listing HTML5 Template</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/logo/favicon.png">

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

</head>

<body>

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
    <header class="header">
        <div class="main-navigation">
            <nav class="navbar navbar-expand-lg">
                <div class="container custom-nav">
                    <a class="navbar-brand" href="index.html">
                        <img src="assets/img/logo/logo.png" class="logo-display" alt="logo">
                        <img src="assets/img/logo/logo-dark.png" class="logo-scrolled" alt="logo">
                    </a>
                    <div class="mobile-menu-right">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-btn-icon"><i class="far fa-bars"></i></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="main_nav">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#"
                                    data-bs-toggle="dropdown">Home</a>
                                <ul class="dropdown-menu fade-down">
                                    <li><a class="dropdown-item" href="index.html">Home One</a></li>
                                    <li><a class="dropdown-item" href="index-2.html">Home Two</a></li>
                                    <li><a class="dropdown-item" href="index-3.html">Home Three</a></li>
                                    <li><a class="dropdown-item" href="index-4.html">Home Four</a></li>
                                    <li><a class="dropdown-item" href="index-5.html">Home Five</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                            <li class="nav-item"><a class="nav-link" href="category.html">Category</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">All Ads</a>
                                <ul class="dropdown-menu fade-down">
                                    <li><a class="dropdown-item" href="ad-grid.html">Ads Grid One</a></li>
                                    <li><a class="dropdown-item" href="ad-grid-2.html">Ads Grid Two</a></li>
                                    <li><a class="dropdown-item" href="ad-grid-3.html">Ads Grid Three</a></li>
                                    <li><a class="dropdown-item" href="ad-list.html">Ads List One</a></li>
                                    <li><a class="dropdown-item" href="ad-list-2.html">Ads List Two</a></li>
                                    <li><a class="dropdown-item" href="ad-list-3.html">Ads List Three</a></li>
                                    <li><a class="dropdown-item" href="ad-single.html">Ads Single One</a></li>
                                    <li><a class="dropdown-item" href="ad-single-2.html">Ads Single Two</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#"
                                    data-bs-toggle="dropdown">Pages</a>
                                <ul class="dropdown-menu fade-down">
                                    <li><a class="dropdown-item" href="about.html">About Us</a></li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item dropdown-toggle" href="#">My Account</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="dashboard.html">Dashboard</a>
                                            <li><a class="dropdown-item" href="profile.html">My Profile</a>
                                            <li><a class="dropdown-item" href="profile-ad.html">My Ads</a>
                                            <li><a class="dropdown-item" href="post-ad.html">Post Ads</a>
                                            <li><a class="dropdown-item" href="profile-ad-setting.html">Ads
                                                    Settings</a>
                                            <li><a class="dropdown-item" href="profile-favorite.html">My Favorites</a>
                                            <li><a class="dropdown-item" href="profile-message.html">Messages</a>
                                            <li><a class="dropdown-item" href="profile-payment.html">Payments</a>
                                            <li><a class="dropdown-item" href="profile-setting.html">Settings</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item dropdown-toggle" href="#">Authentication</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="login.html">Sign In</a></li>
                                            <li><a class="dropdown-item" href="register.html">Sign Up</a></li>
                                            <li><a class="dropdown-item" href="forgot-password.html">Forgot
                                                    Password</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item dropdown-toggle" href="#">Services</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="service.html">Services</a></li>
                                            <li><a class="dropdown-item" href="service-single.html">Service Single</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item dropdown-toggle" href="#">Stores</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="store.html">All Stores</a></li>
                                            <li><a class="dropdown-item" href="store-single.html">Store Single</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item dropdown-toggle" href="#">Extra Pages</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="coming-soon.html">Coming Soon</a></li>
                                            <li><a class="dropdown-item" href="terms.html">Terms Of Service</a></li>
                                            <li><a class="dropdown-item" href="privacy.html">Privacy Policy</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" href="team.html">Our Team</a></li>
                                    <li><a class="dropdown-item" href="pricing.html">Pricing Plan</a></li>
                                    <li><a class="dropdown-item" href="faq.html">Faq</a></li>
                                    <li><a class="dropdown-item" href="testimonial.html">Testimonials</a></li>
                                    <li><a class="dropdown-item" href="404.html">404 Error</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Blog</a>
                                <ul class="dropdown-menu fade-down">
                                    <li><a class="dropdown-item" href="blog.html">Blog One</a></li>
                                    <li><a class="dropdown-item" href="blog-2.html">Blog Two</a></li>
                                    <li><a class="dropdown-item" href="blog-single.html">Blog Single</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                        </ul>
                        <div class="header-nav-right">
                            <div class="header-account">
                                <a href="login.html" class="header-account-link"><i class="far fa-user-circle"></i>
                                    Sign
                                    In</a>
                            </div>
                            <div class="header-btn">
                                <a href="post-ad.html" class="theme-btn mt-2"><span
                                        class="far fa-plus-circle"></span>Post Your Ads</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

    </header>
    <!-- header area end -->



    <main class="main">

        {{-- <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
            <div class="container">
                <h2 class="breadcrumb-title">Ads Single</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Ads Single</li>
                </ul>
            </div>
        </div>

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
        <div class="container">
            <h2 class="breadcrumb-title">{{ $property[0]->title }}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Accueil</a></li>
                {{-- <li class="active">Ads Single</li> --}}
            </ul>
        </div>
    </div>




    <div class="product-single py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="product-single-wrapper">
                        <div class="product-single-slider">
                            <div class="item-gallery">
                                <div class="flexslider-thumbnails">
                                        <ul class="slides">
                                            <li data-thumb="{{ asset('assets/img/product/slider-1.jpg') }}" rel="adjustX:10, adjustY:">
                                                <img src="{{ asset('assets/img/product/slider-1.jpg') }}" alt="#">
                                            </li>
                                            <li data-thumb="{{ asset('assets/img/product/slider-2.jpg') }}">
                                                <img src="{{ asset('assets/img/product/slider-2.jpg') }}" alt="#">
                                            </li>
                                            <li data-thumb="{{ asset('assets/img/product/slider-3.jpg') }}">
                                                <img src="{{ asset('assets/img/product/slider-3.jpg') }}" alt="#">
                                            </li>
                                            <li data-thumb="{{ asset('assets/img/product/slider-4.jpg') }}">
                                                <img src="{{ asset('assets/img/product/slider-4.jpg') }}" alt="#">
                                            </li>
                                            <li data-thumb="{{ asset('assets/img/product/slider-5.jpg') }}">
                                                <img src="{{ asset('assets/img/product/slider-5.jpg') }}" alt="#">
                                            </li>
                                        </ul>
                                    </div>
                            </div>
                        </div>
                        <div class="product-single-top">
                            <div class="product-single-title">
                                <h3>{{ mb_substr(ucfirst($property[0]->title), 0, 34) }}</h3>
                                <p><i class="far fa-clock"></i> Publié le {{ $property[0]->created_at }}</p>
                            </div>
                            <div class="product-single-btn">
                                <a href="#"><i class="far fa-heart"></i></a>
                                <a href="#"><i class="far fa-share-alt"></i></a>
                                <a href="#"><i class="far fa-flag"></i></a>
                            </div>
                        </div>
                        <div class="product-single-price">
                            {{ $property[0]->price }} DT
                        </div>
                        <div class="product-single-moreinfo">
                            <ul>
                                <li><i class="far fa-tag"></i> {{ strtoupper($property[0]->category->name) }}</li>
                                <li><i class=" far fa-bars-sort"></i> {{ strtoupper($property[0]->operation->name) }}</li>
                                
                                <li><i class="far fa-location-dot"></i> {{ $property[0]->city->name }},
                                    {{ $property[0]->area->name }}</li>
                                    <li><i class="far fa-eye"></i> {{ $property[0]->count_views }} Views</li>
                            </ul>
                        </div>
                        <div class="product-single-feature">
                            <h4 class="mb-3">Features</h4>
                            {{-- <div class="product-single-feature-meta">
                                <ul>
                                    <li><span>Brand:</span>Apple</li>
                                    <li><span>Condition:</span>New</li>
                                    <li><span>Authenticity:</span>Original</li>
                                    <li><span>Model:</span>ZX-12345</li>
                                </ul>
                            </div> --}}
                            <div class="product-single-feature-list">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <ul>
                                            @if ($property[0]->wifi == 1)
                                                <li><i class="fad fa-circle-check"></i> wifi</li>
                                            @elseif($property[0]->balcony == 1)
                                                <li><i class="fad fa-circle-check"></i> balcon</li>
                                            @elseif($property[0]->garden == 1)
                                                <li><i class="fad fa-circle-check"></i> Jardin</li>
                                            @elseif($property[0]->garage == 1)
                                                <li><i class="fad fa-circle-check"></i> Garage</li>
                                            @elseif($property[0]->parking == 1)
                                                <li><i class="fad fa-circle-check"></i> Parking</li>
                                            @endif




                                        </ul>
                                    </div>
                                    <div class="col-lg-4">
                                        <ul>
                                            @if ($property[0]->elevator == 1)
                                                <li><i class="fad fa-circle-check"></i> Ascenseur</li>
                                            @elseif($property[0]->heating == 1)
                                                <li><i class="fad fa-circle-check"></i> Chauffage</li>
                                            @elseif($property[0]->air_conditioner == 1)
                                                <li><i class="fad fa-circle-check"></i> Climatisation</li>
                                            @elseif($property[0]->alarm_system == 1)
                                                <li><i class="fad fa-circle-check"></i> Système alarme</li>
                                            @elseif($property[0]->swimming_pool == 1)
                                                <li><i class="fad fa-circle-check"></i> Piscine</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-single-description mt-4">
                            <h4 class="mb-3">Description</h4>
                            <p>
                                {{ $property[0]->description }}
                            </p>

                        </div>
                        {{-- <div class="product-single-location mt-4">
                            <h4 class="mb-3">Location Map</h4> --}}
                        {{-- <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d96708.34194156103!2d-74.03927096447748!3d40.759040329405195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4a01c8df6fb3cb8!2sSolomon%20R.%20Guggenheim%20Museum!5e0!3m2!1sen!2sbd!4v1619410634508!5m2!1sen!2s"
                                style="border:0;" allowfullscreen="" loading="lazy"></iframe> --}}
                        {{-- </div> --}}
                        {{-- <div class="product-single-review mt-5">
                            <h4>Reviews (20)</h4>
                            <div class="listing-single-comments">
                                <div class="blog-comments mb-0">
                                    <div class="blog-comments-wrapper">
                                        <div class="blog-comments-single">
                                            <div class="blog-comments-img"><img src="assets/img/blog/com-1.jpg"
                                                    alt="thumb"></div>
                                            <div class="blog-comments-content">
                                                <h5>Jesse Sinkler</h5>
                                                <span><i class="far fa-clock"></i> 21 Dec, 2023</span>
                                                <p>There are many variations of passages the majority have
                                                    suffered in some injected humour or randomised words which
                                                    don't look even slightly believable.</p>
                                                <a href="#"><i class="far fa-reply"></i> Reply</a>
                                            </div>
                                        </div>
                                        <div class="blog-comments-single blog-comments-reply">
                                            <div class="blog-comments-img"><img src="assets/img/blog/com-2.jpg"
                                                    alt="thumb"></div>
                                            <div class="blog-comments-content">
                                                <h5>Daniel Wellman</h5>
                                                <span><i class="far fa-clock"></i> 21 Dec, 2023</span>
                                                <p>There are many variations of passages the majority have
                                                    suffered in some injected humour or randomised words which
                                                    don't look even slightly believable.</p>
                                                <a href="#"><i class="far fa-reply"></i> Reply</a>
                                            </div>
                                        </div>
                                        <div class="blog-comments-single">
                                            <div class="blog-comments-img"><img src="assets/img/blog/com-3.jpg"
                                                    alt="thumb"></div>
                                            <div class="blog-comments-content">
                                                <h5>Kenneth Evans</h5>
                                                <span><i class="far fa-clock"></i> 21 Dec, 2023</span>
                                                <p>There are many variations of passages the majority have
                                                    suffered in some injected humour or randomised words which
                                                    don't look even slightly believable.</p>
                                                <a href="#"><i class="far fa-reply"></i> Reply</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="blog-comments-form">
                                        <h4 class="mb-4">Leave A Review</h4>
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group mb-3">
                                                        <label class="star-label">Your Rating</label>
                                                        <div class="listing-review-form-star">
                                                            <div class="star-rating-wrapper">
                                                                <div class="star-rating-box">
                                                                    <input type="radio" name="rating" value="5"
                                                                        id="star-5"> <label for="star-5">★</label>
                                                                    <input type="radio" name="rating" value="4"
                                                                        id="star-4"> <label for="star-4">★</label>
                                                                    <input type="radio" name="rating" value="3"
                                                                        id="star-3"> <label for="star-3">★</label>
                                                                    <input type="radio" name="rating" value="2"
                                                                        id="star-2"> <label for="star-2">★</label>
                                                                    <input type="radio" name="rating" value="1"
                                                                        id="star-1"> <label for="star-1">★</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            placeholder="Your Name*">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control"
                                                            placeholder="Your Email*">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control" rows="5" placeholder="Your Review*"></textarea>
                                                    </div>
                                                    <button type="submit" class="theme-btn">Submit Review <i
                                                            class="far fa-paper-plane"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-single-related mt-5">
                            <h4 class="mb-4">Related Ads</h4>
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="product-item">
                                        <div class="product-img">
                                            <span class="product-status trending"><i
                                                    class="fas fa-bolt-lightning"></i></span>
                                            <img src="assets/img/product/01.jpg" alt="">
                                            <a href="#" class="product-favorite"><i class="far fa-heart"></i></a>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-top">
                                                <div class="product-category">
                                                    <div class="product-category-icon">
                                                        <i class="far fa-tv"></i>
                                                    </div>
                                                    <h6 class="product-category-title"><a href="#">Electronics</a>
                                                    </h6>
                                                </div>
                                                <div class="product-rate">
                                                    <i class="fas fa-star"></i>
                                                    <span>4.5</span>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h5><a href="#">Wireless Headphone</a></h5>
                                                <p><i class="far fa-location-dot"></i> 25/A Road New York, USA</p>
                                                <div class="product-date"><i class="far fa-clock"></i> 10 Days Ago</div>
                                            </div>
                                            <div class="product-bottom">
                                                <div class="product-price">$180</div>
                                                <a href="#" class="product-text-btn">View Details <i
                                                        class="fas fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="product-item">
                                        <div class="product-img">
                                            <img src="assets/img/product/02.jpg" alt="">
                                            <a href="#" class="product-favorite"><i class="far fa-heart"></i></a>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-top">
                                                <div class="product-category">
                                                    <div class="product-category-icon">
                                                        <i class="far fa-watch"></i>
                                                    </div>
                                                    <h6 class="product-category-title"><a href="#">Fashions</a></h6>
                                                </div>
                                                <div class="product-rate">
                                                    <i class="fas fa-star"></i>
                                                    <span>4.5</span>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h5><a href="#">Men's Golden Watch</a></h5>
                                                <p><i class="far fa-location-dot"></i> 25/A Road New York, USA</p>
                                                <div class="product-date"><i class="far fa-clock"></i> 10 Days Ago</div>
                                            </div>
                                            <div class="product-bottom">
                                                <div class="product-price">$120</div>
                                                <a href="#" class="product-text-btn">View Details <i
                                                        class="fas fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="product-item">
                                        <div class="product-img">
                                            <span class="product-status new">New</span>
                                            <img src="assets/img/product/03.jpg" alt="">
                                            <a href="#" class="product-favorite"><i class="far fa-heart"></i></a>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-top">
                                                <div class="product-category">
                                                    <div class="product-category-icon">
                                                        <i class="far fa-mobile-button"></i>
                                                    </div>
                                                    <h6 class="product-category-title"><a href="#">Mobiles</a></h6>
                                                </div>
                                                <div class="product-rate">
                                                    <i class="fas fa-star"></i>
                                                    <span>4.5</span>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h5><a href="#">iPhone 12 Pro</a></h5>
                                                <p><i class="far fa-location-dot"></i> 25/A Road New York, USA</p>
                                                <div class="product-date"><i class="far fa-clock"></i> 10 Days Ago</div>
                                            </div>
                                            <div class="product-bottom">
                                                <div class="product-price">$320</div>
                                                <a href="#" class="product-text-btn">View Details <i
                                                        class="fas fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="product-sidebar">
                        <div class="product-single-sidebar-item">
                            <h5 class="title">Seller Info</h5>
                            <div class="product-single-author">
                                <img src="{{ asset('assets/img/store/01.jpg') }}" alt="">
                                <h6><a href="#">{{ $user->username }}</a></h6>
                                <span>{{ $user->email }}</span>
                                <div class="product-single-author-phone">
                                    <span>
                                        <i class="far fa-phone"></i>
                                        <span class="author-number">
                                            {{-- {{ dd($user) }} --}}
                                            {{ substr($user->phone, 0, 6) }}XXXX</span>
                                        <span class="author-reveal-number">{{ $user->phone }}</span>
                                    </span>
                                    <p>Cliquez pour afficher le numéro de téléphone</p>
                                </div>
                                <a href="#" class="theme-border-btn w-100 mt-4"><i class="far fa-phone"></i>
                                    Appeller</a>
                            </div>
                            <div class="product-single-sidebar-item mt-5">
                                <h5 class="title">Safety Tips For Buyer</h5>
                                <div class="product-single-safety">
                                    <ul>
                                        <li><i class="far fa-check"></i> Meet seller in public place</li>
                                        <li><i class="far fa-check"></i> Check The item before buy</li>
                                        <li><i class="far fa-check"></i> Pay after collecting item</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- product single -->
        <div class="product-single py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 mb-4">
                        <div class="product-single-wrapper">
                            <div class="product-single-slider">
                                <div class="item-gallery">
                                    <div class="flexslider-thumbnails">
                                        <ul class="slides">
                                            <li data-thumb="assets/img/product/slider-1.jpg"
                                                rel="adjustX:10, adjustY:">
                                                <img src="assets/img/product/slider-1.jpg" alt="#">
                                            </li>
                                            <li data-thumb="assets/img/product/slider-2.jpg">
                                                <img src="assets/img/product/slider-2.jpg" alt="#">
                                            </li>
                                            <li data-thumb="assets/img/product/slider-3.jpg">
                                                <img src="assets/img/product/slider-3.jpg" alt="#">
                                            </li>
                                            <li data-thumb="assets/img/product/slider-4.jpg">
                                                <img src="assets/img/product/slider-4.jpg" alt="#">
                                            </li>
                                            <li data-thumb="assets/img/product/slider-5.jpg">
                                                <img src="assets/img/product/slider-5.jpg" alt="#">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="product-single-top">
                                <div class="product-single-title">
                                    <h3>Men's Golden Watch</h3>
                                    <p><i class="far fa-clock"></i> Posted on 05 December 2023, 10:00 AM</p>
                                </div>
                                <div class="product-single-btn">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#"><i class="far fa-share-alt"></i></a>
                                    <a href="#"><i class="far fa-flag"></i></a>
                                </div>
                            </div>
                            <div class="product-single-price">
                                $1,520.00
                            </div>
                            <div class="product-single-moreinfo">
                                <ul>
                                    <li><i class="far fa-tag"></i> Fashion</li>
                                    <li><i class="far fa-dollar-sign"></i> Fixed Price</li>
                                    <li><i class="far fa-eye"></i> 1,200 Views</li>
                                    <li><i class="far fa-location-dot"></i> 25/A Road New York, USA</li>
                                </ul>
                            </div>
                            <div class="product-single-feature">
                                <h4 class="mb-3">Features</h4>
                                <div class="product-single-feature-meta">
                                    <ul>
                                        <li><span>Brand:</span>Apple</li>
                                        <li><span>Condition:</span>New</li>
                                        <li><span>Authenticity:</span>Original</li>
                                        <li><span>Model:</span>ZX-12345</li>
                                    </ul>
                                </div>
                                <div class="product-single-feature-list">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <ul>
                                                <li><i class="fad fa-circle-check"></i> Dual Camera</li>
                                                <li><i class="fad fa-circle-check"></i> Multi Screen</li>
                                                <li><i class="fad fa-circle-check"></i> 1 Year International Warranty
                                                </li>
                                                <li><i class="fad fa-circle-check"></i> 10 Hour Battery Life</li>
                                                <li><i class="fad fa-circle-check"></i> Dual Sim</li>
                                                <li><i class="fad fa-circle-check"></i> Touch Fingerprint</li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-4">
                                            <ul>
                                                <li><i class="fad fa-circle-check"></i> Dual Camera</li>
                                                <li><i class="fad fa-circle-check"></i> Multi Screen</li>
                                                <li><i class="fad fa-circle-check"></i> 1 Year International Warranty
                                                </li>
                                                <li><i class="fad fa-circle-check"></i> 10 Hour Battery Life</li>
                                                <li><i class="fad fa-circle-check"></i> Dual Sim</li>
                                                <li><i class="fad fa-circle-check"></i> Touch Fingerprint</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-single-description mt-4">
                                <h4 class="mb-3">Description</h4>
                                <p>
                                    There are many variations of passages available, but the majority have suffered
                                    alteration in some form, by injected humour, or randomised words which don't look
                                    even slightly believable. If you are going to use a passage of Lorem Ipsum, you need
                                    to be sure there isn't anything embarrassing hidden in the middle of text. All the
                                    Lorem Ipsum generators on the Internet tend to repeat predefined chunks as
                                    necessary, making this the first true generator on the Internet.
                                </p>
                                <p class="mt-3">
                                    It is a long established fact that a reader will be distracted by the readable
                                    content of a page when looking at its layout. The point of using Lorem Ipsum is that
                                    it has a more-or-less normal distribution of letters, as opposed to using 'Content
                                    here, content here', making it look like readable English. Many desktop publishing
                                    packages and web page editors now use Lorem Ipsum as their default model text, and a
                                    search for 'lorem ipsum' will uncover many web sites still in their infancy.
                                </p>
                            </div>
                            <div class="product-single-location mt-4">
                                <h4 class="mb-3">Location Map</h4>
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d96708.34194156103!2d-74.03927096447748!3d40.759040329405195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4a01c8df6fb3cb8!2sSolomon%20R.%20Guggenheim%20Museum!5e0!3m2!1sen!2sbd!4v1619410634508!5m2!1sen!2s"
                                    style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                            <div class="product-single-review mt-5">
                                <h4>Reviews (20)</h4>
                                <div class="listing-single-comments">
                                    <div class="blog-comments mb-0">
                                        <div class="blog-comments-wrapper">
                                            <div class="blog-comments-single">
                                                <div class="blog-comments-img"><img src="assets/img/blog/com-1.jpg"
                                                        alt="thumb"></div>
                                                <div class="blog-comments-content">
                                                    <h5>Jesse Sinkler</h5>
                                                    <span><i class="far fa-clock"></i> 21 Dec, 2023</span>
                                                    <p>There are many variations of passages the majority have
                                                        suffered in some injected humour or randomised words which
                                                        don't look even slightly believable.</p>
                                                    <a href="#"><i class="far fa-reply"></i> Reply</a>
                                                </div>
                                            </div>
                                            <div class="blog-comments-single blog-comments-reply">
                                                <div class="blog-comments-img"><img src="assets/img/blog/com-2.jpg"
                                                        alt="thumb"></div>
                                                <div class="blog-comments-content">
                                                    <h5>Daniel Wellman</h5>
                                                    <span><i class="far fa-clock"></i> 21 Dec, 2023</span>
                                                    <p>There are many variations of passages the majority have
                                                        suffered in some injected humour or randomised words which
                                                        don't look even slightly believable.</p>
                                                    <a href="#"><i class="far fa-reply"></i> Reply</a>
                                                </div>
                                            </div>
                                            <div class="blog-comments-single">
                                                <div class="blog-comments-img"><img src="assets/img/blog/com-3.jpg"
                                                        alt="thumb"></div>
                                                <div class="blog-comments-content">
                                                    <h5>Kenneth Evans</h5>
                                                    <span><i class="far fa-clock"></i> 21 Dec, 2023</span>
                                                    <p>There are many variations of passages the majority have
                                                        suffered in some injected humour or randomised words which
                                                        don't look even slightly believable.</p>
                                                    <a href="#"><i class="far fa-reply"></i> Reply</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="blog-comments-form">
                                            <h4 class="mb-4">Leave A Review</h4>
                                            <form action="#">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <label class="star-label">Your Rating</label>
                                                            <div class="listing-review-form-star">
                                                                <div class="star-rating-wrapper">
                                                                    <div class="star-rating-box">
                                                                        <input type="radio" name="rating"
                                                                            value="5" id="star-5"> <label
                                                                            for="star-5">&#9733;</label>
                                                                        <input type="radio" name="rating"
                                                                            value="4" id="star-4"> <label
                                                                            for="star-4">&#9733;</label>
                                                                        <input type="radio" name="rating"
                                                                            value="3" id="star-3"> <label
                                                                            for="star-3">&#9733;</label>
                                                                        <input type="radio" name="rating"
                                                                            value="2" id="star-2"> <label
                                                                            for="star-2">&#9733;</label>
                                                                        <input type="radio" name="rating"
                                                                            value="1" id="star-1"> <label
                                                                            for="star-1">&#9733;</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                placeholder="Your Name*">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="email" class="form-control"
                                                                placeholder="Your Email*">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control" rows="5" placeholder="Your Review*"></textarea>
                                                        </div>
                                                        <button type="submit" class="theme-btn">Submit Review <i
                                                                class="far fa-paper-plane"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-single-related mt-5">
                                <h4 class="mb-4">Related Ads</h4>
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="product-status trending"><i
                                                        class="fas fa-bolt-lightning"></i></span>
                                                <img src="assets/img/product/01.jpg" alt="">
                                                <a href="#" class="product-favorite"><i
                                                        class="far fa-heart"></i></a>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-top">
                                                    <div class="product-category">
                                                        <div class="product-category-icon">
                                                            <i class="far fa-tv"></i>
                                                        </div>
                                                        <h6 class="product-category-title"><a
                                                                href="#">Electronics</a></h6>
                                                    </div>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <span>4.5</span>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <h5><a href="#">Wireless Headphone</a></h5>
                                                    <p><i class="far fa-location-dot"></i> 25/A Road New York, USA</p>
                                                    <div class="product-date"><i class="far fa-clock"></i> 10 Days Ago
                                                    </div>
                                                </div>
                                                <div class="product-bottom">
                                                    <div class="product-price">$180</div>
                                                    <a href="#" class="product-text-btn">View Details <i
                                                            class="fas fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <img src="assets/img/product/02.jpg" alt="">
                                                <a href="#" class="product-favorite"><i
                                                        class="far fa-heart"></i></a>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-top">
                                                    <div class="product-category">
                                                        <div class="product-category-icon">
                                                            <i class="far fa-watch"></i>
                                                        </div>
                                                        <h6 class="product-category-title"><a
                                                                href="#">Fashions</a></h6>
                                                    </div>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <span>4.5</span>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <h5><a href="#">Men's Golden Watch</a></h5>
                                                    <p><i class="far fa-location-dot"></i> 25/A Road New York, USA</p>
                                                    <div class="product-date"><i class="far fa-clock"></i> 10 Days Ago
                                                    </div>
                                                </div>
                                                <div class="product-bottom">
                                                    <div class="product-price">$120</div>
                                                    <a href="#" class="product-text-btn">View Details <i
                                                            class="fas fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <span class="product-status new">New</span>
                                                <img src="assets/img/product/03.jpg" alt="">
                                                <a href="#" class="product-favorite"><i
                                                        class="far fa-heart"></i></a>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-top">
                                                    <div class="product-category">
                                                        <div class="product-category-icon">
                                                            <i class="far fa-mobile-button"></i>
                                                        </div>
                                                        <h6 class="product-category-title"><a
                                                                href="#">Mobiles</a></h6>
                                                    </div>
                                                    <div class="product-rate">
                                                        <i class="fas fa-star"></i>
                                                        <span>4.5</span>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <h5><a href="#">iPhone 12 Pro</a></h5>
                                                    <p><i class="far fa-location-dot"></i> 25/A Road New York, USA</p>
                                                    <div class="product-date"><i class="far fa-clock"></i> 10 Days Ago
                                                    </div>
                                                </div>
                                                <div class="product-bottom">
                                                    <div class="product-price">$320</div>
                                                    <a href="#" class="product-text-btn">View Details <i
                                                            class="fas fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="product-sidebar">
                            <div class="product-single-sidebar-item">
                                <h5 class="title">Seller Info</h5>
                                <div class="product-single-author">
                                    <img src="assets/img/store/01.jpg" alt="">
                                    <h6><a href="#">Ako Electronic</a></h6>
                                    <span>Member Since 2020</span>
                                    <div class="product-single-author-phone">
                                        <span>
                                            <i class="far fa-phone"></i>
                                            <span class="author-number">+2 123 XXX XXXX</span>
                                            <span class="author-reveal-number">+2 123 654 7898</span>
                                        </span>
                                        <p>Click to reveal phone number</p>
                                    </div>
                                    <a href="#" class="theme-border-btn w-100 mt-4"><i
                                            class="far fa-messages"></i> Send Message</a>
                                </div>
                                <div class="product-single-sidebar-item mt-5">
                                    <h5 class="title">Safety Tips For Buyer</h5>
                                    <div class="product-single-safety">
                                        <ul>
                                            <li><i class="far fa-check"></i> Meet seller in public place</li>
                                            <li><i class="far fa-check"></i> Check The item before buy</li>
                                            <li><i class="far fa-check"></i> Pay after collecting item</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- product single --> --}}


    </main>



    <!-- footer area -->
    <footer class="footer-area">
        <div class="footer-widget">
            <div class="container">
                <div class="row footer-widget-wrapper pt-100 pb-70">
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box about-us">
                            <a href="#" class="footer-logo">
                                <img src="assets/img/logo/logo.png" alt="">
                            </a>
                            <p class="mb-4">
                                We are many variations passages available have suffered alteration
                                in some form by injected humour.
                            </p>
                            <ul class="footer-contact">
                                <li><a href="tel:+21236547898"><i class="far fa-phone"></i>+2 123 654 7898</a></li>
                                <li><i class="far fa-map-marker-alt"></i>25/B Milford Road, New York</li>
                                <li><a href="mailto:info@example.com"><i
                                            class="far fa-envelope"></i>info@example.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Company</h4>
                            <ul class="footer-list">
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> About Us</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Our Team</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Contact Us</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Terms Of Service</a>
                                </li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Privacy policy</a>
                                </li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Careers</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Quick Links</h4>
                            <ul class="footer-list">
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Membership</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Buy and Sell
                                        Quickly</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Banner Advertising</a>
                                </li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Promote Your Ads</a>
                                </li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Our Partners</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Latest Blog</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Help & Support</h4>
                            <ul class="footer-list">
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> FAQ's</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Live Chat</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> How Stay Safe</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Selling Tips</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Community</a></li>
                                <li><a href="#"><i class="fas fa-angle-double-right"></i> Sitemap</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Newsletter</h4>
                            <div class="footer-newsletter">
                                <p>Subscribe Our Newsletter To Get Latest Update And News</p>
                                <div class="subscribe-form">
                                    <form action="#">
                                        <div class="form-group">
                                            <div class="form-group-icon">
                                                <i class="far fa-envelope"></i>
                                                <input type="email" class="form-control" placeholder="Your Email">
                                                <button class="theme-btn" type="submit">
                                                    <span class="far fa-paper-plane"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="footer-payment-method">
                                <h6>We Accept</h6>
                                <div class="payment-method-img">
                                    <img src="assets/img/payment/paypal.svg" alt="">
                                    <img src="assets/img/payment/mastercard.svg" alt="">
                                    <img src="assets/img/payment/visa.svg" alt="">
                                    <img src="assets/img/payment/discover.svg" alt="">
                                    <img src="assets/img/payment/american-express.svg" alt="">
                                </div>
                            </div>
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
                            &copy; Copyright <span id="date"></span> <a href="#"> CLASAD </a> All Rights
                            Reserved.
                        </p>
                    </div>
                    <div class="col-md-6 align-self-center">
                        <ul class="footer-social">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer area end -->
    <!-- scroll-top -->
    <a href="#" id="scroll-top"><i class="far fa-angle-up"></i></a>
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

</body>

</html>
