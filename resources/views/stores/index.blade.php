@extends('layouts.app')

@section('pageTitle')
Stores
@endsection
@section('content')
{{-- {{ dd($stores) }} --}}
<!-- breadcrumb -->
@include('includes.slider')

<div class="product-area py-120">
    <div class="container">
        <div class="row">
            <div class="col-md-6" style="
                display: flex;
                justify-content: space-between;
                        ">

                <form action="{{ route('stores') }}" method="GET">
                    <input type="hidden" name="type" value="">

                    <button type="submit" class="btn btn-sm btn-primary" style="background: #fc3131;
                                color: #fff;
                                border-radius: 8px;
                                border-color: #fc3131;">
                        <i class="far fa-search"></i>
                        Tous</button>

                </form>
                <form action="{{ route('stores') }}" method="GET">
                    <input type="hidden" name="type" value="company">

                    <button type="submit" class="btn btn-sm btn-primary" style="background: #fc3131;
                        color: #fff;
                        border-radius: 8px;
                        border-color: #fc3131;">
                        <i class="far fa-search"></i>
                        Entreprise </button>
                </form>
                <form action="{{ route('stores') }}" method="GET">
                    <input type="hidden" name="type" value="promoteur">

                    <button type="submit" class="btn btn-sm btn-primary" style="background: #fc3131;
                        color: #fff;
                        border-radius: 8px;
                        border-color: #fc3131;">
                        <i class="far fa-search"></i>
                        Promoteur</button>

                </form>
            </div>




        </div>
        <hr>
        <div class="row">
            <div class="col-lg-9 row">
                @foreach ($stores as $item)
                <div class="col-md-3">
                    <a href="{{ route('all_product_store', $item->slug) }}" class="store-item">
                        <div class="store-img">

                            <img src="{{ asset($item->logo ? 'uploads/store_logos/' . $item->logo : 'assets/img/store/01.jpg') }}" alt="">
                        </div>
                        <div class="store-content">
                            <h6>{{ Str::ucfirst($item->store_name) }}</h6>
                            {{-- <span>5 Ads</span> --}}
                        </div>
                    </a>
                </div>
                {{-- </div> --}}
                {{-- @endif --}}
                @endforeach

                {!! $stores->appends(request()->query())->links('vendor.pagination.default') !!}
            </div>

            <div class="col-lg-3 product-sidebar">
                @include('includes.ads')
            </div>
        </div>
    </div>

</div>
@endsection