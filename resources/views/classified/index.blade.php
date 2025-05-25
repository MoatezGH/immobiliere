@extends('layouts.app')
@section('pageTitle')
    Annonces
@endsection
@section('content')
    <style>

        .product-favorite,
        .product-status {
            font-size: 12px;
        }
        .product-date,
        .product-info p {
            font-size: 12px;
        }
    </style>

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
    {{-- {{ dd($classifieds) }} --}}

    <!-- breadcrumb -->
    @include("includes.slider")




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
                                {{ $classifieds->appends(request()->query())->total() }} Résultats</h6>

                        </div>
                    </div>
                    <div class="row">


                        @foreach ($classifieds as $item)
                            {{-- {{ dd($item) }} --}}

                            
                            <div class="col-md-6 col-lg-4">
                                @include('includes.classified.item_classified')
                                
                            </div>
                        @endforeach


                        <!-- pagination -->
                        {!! $classifieds->appends(request()->query())->links('vendor.pagination.default') !!}
                    </div>
                </div>

                <div class="col-lg-3 mb-4">
                    <div class="product-sidebar">
                        <div class="search-form">
                            <form action="{{ route('index_classified_front') }}" method="GET">
                                @csrf
                                
                                @include('includes.classified.search_form_classified')

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
