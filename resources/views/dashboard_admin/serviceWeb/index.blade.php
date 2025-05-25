@extends('layouts.dashboard')
@section('pageTitle')
    Tous les Sliders
@endsection
@section('sectionTitle')
    Tous les Sliders
@endsection
@section('content')
{{-- {{ Route::current()->getName() }} --}}
    <style>
        .search-form .nice-select {
            height: 45px;
            display: flex;
            align-items: center;
        }
    </style>
    {{-- <div class="col-4"></div> --}}
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

    <div class="user-profile-wrapper">
        <div class="user-profile-card profile-ad">
            <h6>Affichage

                {{ $sliders->appends(request()->query())->total() }}
                Résultats</h6>

            <div class="user-profile-card-header mt-2 flex-end">
                <a href="{{ route('admin.add_service_web') }}" class="theme-btn">Ajouter</a>
            </div>


        </div>
        <div class="col-lg-12">
            @if (count($sliders) > 0)
                <div class="row">
                    @foreach ($sliders as $item)
                        <div class="col-md-6">
                        <div class="blog-item">
                            <div class="blog-item-img">
                                <img src="{{asset("uploads/serviceWeb/".$item->imageUrl)}}" style="height:100px;width:100px" alt="Thumb">
                            </div>
                            <div class="blog-item-info">

                                <h4 class="blog-title">
                                    <a href="#">{{ $item->title}}</a>
                                </h4>
                                <a class="theme-btn" href="{{route('admin.edit_service_web',$item->id)}}">Détails<i class="fas fa-arrow-right"></i></a>


                                <a href="#"
                                                class="theme-btn delete-property"
                                                data-bs-toggle="tooltip" aria-label="Delete"
                                                onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce service?')) { document.getElementById('delete-property-form-{{ $item->id }}').submit(); }"
                                                data-bs-original-title="supprimer"><i class="far fa-trash-can"></i></a>

                                            <form display="none" id="delete-property-form-{{ $item->id }}"
                                                action="{{ route('admin.delete_service_web', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                            </form>

                            </div>
                            <p>{{ $item->created_at->format('d-m-Y') }}</p>
                        </div>
                    </div>
                    @endforeach


                </div>

                {!! $sliders->appends(request()->query())->links('vendor.pagination.default') !!}
            @else
                <p>Pas des services</p>
            @endif
        </div>
    </div>
    </div>
@endsection
