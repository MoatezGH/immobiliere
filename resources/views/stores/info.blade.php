@extends('layouts.app')
@section('content')
    {{-- {{ dd($user_type) }} --}}
    <style>

        .product-favorite,
        .product-status {
            font-size: 12px;
        }
        .product-date,
        .product-info p {
            font-size: 12px;
        }
        .product-info >p , .product-date , .product-category-title{
            font-size: 12px !important;
        }
    </style>
    <!-- breadcrumb -->
    {{-- <div class="site-breadcrumb"
        style="background: url({{ asset($store[0]->banner ? 'uploads/store_banners/' . $store[0]->banner : 'assets/img/breadcrumb/01.jpg') }})">
        <div class="container">
            <h2 class="breadcrumb-title">{{ ucfirst($store[0]->store_name) }}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Accueil</a></li>
                <li class="active">{{ ucfirst($store[0]->store_name) }}</li>
            </ul>
        </div>
    </div> --}}

    @include('includes.slider')



    <!-- product area -->
    <div class="product-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <div class="product-sidebar">
                        <div class="search-form">
                            <form action="#">
                                @include('includes.user_details_store')
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="col-md-12">
                        <div class="product-sort">
                            <h6>Affichage
                                {{-- {{ $props->appends(request()->query())->currentPage() }}-{{ $props->appends(request()->query())->perPage() }}
                                à  --}}
                                {{ $props->appends(request()->query())->total() }} Résultats</h6>

                        </div>
                    </div>
                    <div class="row">
                        

                        @foreach ($props as $item)
                        <?php $class = get_class($item); ?>
                            {{-- {{ dd($class) }} --}}
                            

                            {{-- <div class="col-md-6 "> --}}
                            {{-- @include('includes.item_promoteur_property') --}}
                            {{-- @if ($user_type == 'promoteur')
                                @include('includes.item_promoteur_property')
                            @else --}}
                            <div class="col-md-6">
                                {{-- @if() --}}
                                @if($class =="App\Models\Property")
                                @include('includes.item_property')
                                @else
                            @include('includes.item_promoteur_property')
                            @endif

                            </div>
                            {{-- @endif --}}
                            {{-- </div> --}}
                        @endforeach


                        <!-- pagination -->
                        {!! $props->appends(request()->query())->links('vendor.pagination.default') !!}
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <div class="product-sidebar">
                        <div class="search-form">
                            <form action="#">
                                
                                @include('includes.search_form_promoteur')
                            </form>
                        </div>
                    </div>
                    @include("includes.ads")
                </div>
            </div>
        </div>
    </div>
    <!-- product area end -->
@endsection
