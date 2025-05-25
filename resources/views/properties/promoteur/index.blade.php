@extends('layouts.app')
@section('pageTitle')
    Direct Promoteurs
@endsection
@section('content')
    {{-- {{ dd('0102') }} --}}
    <style>
        @media only screen and (max-width: 600px) {
            .site-breadcrumb {
                background-size: contain !important;
                /* margin-top: -200px !important; */
            }


            

            .site-breadcrumb {
                padding-top: 50px;
                padding-bottom: 50px;

            }

        }

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
    </style>
    {{-- {{ dd(request()->min_price) }} --}}
    {{-- {{ dd($props->appends(request()->query())) }} --}}

    <!-- breadcrumb -->
    {{-- <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">Les Annonces Direct Promoteurs</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Accueil</a></li>
                <li class="active">Immobiliers Neufs</li>
            </ul>
        </div>
        <div class="container">
            <img class="sli" src="{{ asset('images/new/10.png') }}" alt="">
        </div>
    </div> --}}

    @include('includes.slider')

    <!-- product area -->
    <div class="product-area py-120">
        <div class="container">
            <div class="row">
                
                <div class="col-lg-9">
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
                            {{-- {{ dd($item) }} --}}

                            <div class="col-md-6 ">
                                @include('includes.item_promoteur_property')
                                
                            </div>
                        @endforeach


                        <!-- pagination -->
                        {!! $props->appends(request()->query())->links('vendor.pagination.default') !!}
                    </div>
                </div>

                <div class="col-lg-3 mb-4">
                    <div class="product-sidebar">
                        <div class="search-form">
                            <form action="{{ route('all_properties_promoteur') }}" method="POST">
                                @csrf

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
