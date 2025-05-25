@extends('layouts.dashboard')
@section('pageTitle')
    Tous les Partenaires
@endsection
@section('sectionTitle')
    Tous les Partenaires
@endsection
@section('content')
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

                {{ $partenaires->appends(request()->query())->total() }}
                Résultats</h6>

            <div class="user-profile-card-header mt-2 flex-end">
                <a href="{{ route('admin.partenaires.create') }}" class="theme-btn">Ajouter</a>
            </div>


        </div>
        <div class="col-lg-12">
            @if (count($partenaires) > 0)
                <div class="row">
                    @foreach ($partenaires as $item)
                        <div class="col-md-6">
                        <div class="blog-item">
                            <div class="blog-item-img">
                                <img src="{{asset("uploads/partenaire/".$item->image_url)}}" style="height:266px;width:400px" alt="Thumb">
                            </div>
                            <div class="blog-item-info">
                                
                                <h4 class="blog-title">
                                    <a href="#">{{ $item->description}}</a>
                                </h4>
                                <a class="theme-btn" href="{{route('admin.partenaires.edit',$item->id)}}">Détails<i class="fas fa-arrow-right"></i></a>

                                <a class="theme-btn" href="{{ route('admin.slider_ip',$item->id) }}">{{ $item->view_count }}<i class="fas fa-eye"></i></a>

                                <a href="#"
                                                class="theme-btn delete-property"
                                                data-bs-toggle="tooltip" aria-label="Delete"
                                                onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce partenaire?')) { document.getElementById('delete-property-form-{{ $item->id }}').submit(); }"
                                                data-bs-original-title="supprimer"><i class="far fa-trash-can"></i></a>

                                            <form display="none" id="delete-property-form-{{ $item->id }}"
                                                action="{{ route('admin.partenaires.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                            </form>

                            </div>
                            <p>{{ $item->created_at->format('d-m-Y') }}</p>
                        </div>
                    </div>
                    @endforeach
                    
                    
                </div>

                {!! $partenaires->appends(request()->query())->links('vendor.pagination.default') !!}
            @else
                <p>Pas des partenaires</p>
            @endif
        </div>
    </div>
    </div>
@endsection
