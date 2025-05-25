@extends('layouts.app')
@section('content')
    {{-- {{ dd($user_type) }} --}}

    <!-- breadcrumb -->
    <div class="site-breadcrumb"
        style="background: url({{ asset($store[0]->banner ? 'uploads/store_banners/' . $store[0]->banner : 'assets/img/breadcrumb/01.jpg') }})">
        <div class="container">
            <h2 class="breadcrumb-title">{{ ucfirst($store[0]->store_name) }}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Accueil</a></li>
                <li class="active">{{ ucfirst($store[0]->store_name) }}</li>
            </ul>
        </div>
    </div>



    <!-- product area -->
    <div class="product-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <div class="product-sidebar">
                        <div class="search-form">
                            <form action="{{ route('all_product_store', $store[0]->slug) }}" method="POST">
                                @csrf
                                @include('includes.search_form_property')
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="col-md-12">
                        <div class="product-sort">
                            <h6>Affichage
                                {{-- {{ $props->appends(request()->query())->currentPage() }}-{{ $props->appends(request()->query())->perPage() }}
                                à  --}}
                                {{ $props->appends(request()->query())->total() }} Résultats</h6>

                        </div>
                    </div>
                    {{-- <div class="row">
                        

                        @foreach ($props as $item)
                            

                            
                            @if ($user_type == 'promoteur')
                                @include('includes.item_promoteur_property')
                            @else
                                @include('includes.item_property')
                            @endif
                            
                        @endforeach


                        <!-- pagination -->
                        {!! $props->appends(request()->query())->links('vendor.pagination.default') !!}
                    </div> --}}
                    <div class="row">
                        {{-- <div class="col-md-6 col-lg-4">
                                <div class="product-item">
                                    <div class="product-img">
                                        <span class="product-status trending"><i class="fas fa-bolt-lightning"></i></span>
                                        <img src="assets/img/product/01.jpg" alt="">
                                        <a href="#" class="product-favorite"><i class="far fa-heart"></i></a>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-top">
                                            <div class="product-category">
                                                <div class="product-category-icon">
                                                    <i class="far fa-tv"></i>
                                                </div>
                                                <h6 class="product-category-title"><a href="#">Electronics</a></h6>
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
                                            <a href="#" class="product-text-btn">View Details <i class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                        @foreach ($props as $item)
                            {{-- {{ dd($item) }} --}}

                            <div class="col-md-6 ">
                                {{-- @include('includes.item_promoteur_property') --}}
                                @if ($user_type == 'promoteur')
                                @include('includes.item_promoteur_property')
                            @else
                                @include('includes.item_property')
                            @endif
                                {{-- <div class="product-item">
                                    <div class="product-img">
                                        <span class="product-status featured">{{ strtoupper($item->ref) }}</span>
                                        @if ($item->getFirstImageOrDefault())
                                            <img src="{{ asset('uploads/promoteur_property/' . $item->getFirstImageOrDefault()) }}"
                                                alt="">
                                        @else
                                            <img src="{{ asset('assets/img/product/01.jpg') }}" alt="">
                                        @endif

                                        

                                        <a href="#" class="product-favorite">{{ ucfirst($item->category->name) }}
                                            {{ $item->operation->title }}</a>

                                    </div>
                                    <div class="product-content">
                                        <div class="product-top">
                                            <div class="product-category">
                                                <div class="product-category-icon">
                                                    <i class="far fa-heart"></i>
                                                </div>
                                                <h6 class="product-category-title"><a
                                                        href="#">{{ ucfirst($item->user->username) }}
                                                        </a></h6>
                                            </div>
                                            
                                        </div>
                                        <div class="product-info">

                                            <p><img src="{{ asset('icon_png/location.png') }}" alt=""
                                                    style="width:55px;margin-left: -9px;">
                                                {{ $item->city->name }} ,
                                                {{ $item->area->name }}</p>
                                            
                                            <div class="product-date">
                                                <img src="{{ asset('icon_png/calendar.png') }}" alt=""
                                                    style="width:35px">
                                                {{ date('d M Y', strtotime($item->created_at)) }}
                                            </div>
                                            <div class="product-date">
                                                <img src="{{ asset('icon_png/m2.png') }}" alt=""
                                                    style="width:55px;margin-left: -9px;">
                                                {{ $item->surface_totale }} m²
                                            </div>



                                        </div>
                                        
                                        <div class="product-bottom">
                                            <div class="product-price">

                                                {{ $item->price_total }} DT


                                            </div>
                                            <a href="{{ route('prop_info_promoteur', $item->slug) }}"
                                                class="product-text-btn">View
                                                Details <i class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        @endforeach


                        <!-- pagination -->
                        {!! $props->appends(request()->query())->links('vendor.pagination.default') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product area end -->
@endsection
