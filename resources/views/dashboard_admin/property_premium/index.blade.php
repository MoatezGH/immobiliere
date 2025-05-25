@extends('layouts.dashboard')
@section('pageTitle')
    Tous les Annonces Premium
@endsection
@section('sectionTitle')
    Tous les Annonces Premium
@endsection
@section('content')
    {{-- {{dd("enter")}} --}}
{{-- {{ Route::current()->getName() }} --}}
    <style>
        .search-form .nice-select {
            height: 45px;
            display: flex;
            align-items: center;
        }

        td ,th,h6 {
            font-size: 11px;
        }

        /* .search-form .nice-select .list{
                                                                                                            width: auto;

                                                                                                        } */
    </style>
    {{-- {{ dd($properties) }} --}}
    {{-- @foreach ($users as $item)
    {{dd($item)}}
@endforeach --}}
    {{-- <div class="col-lg-9"> --}}
    @if ($errors->has('propertyError'))
        <div class="alert alert-danger">
            {{ $errors->first('propertyError') }}
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

                {{ $properties->appends(request()->query())->total() }} Résultats</h6>

            <div class="user-profile-card-header mt-3">
                {{-- <h4 class="user-profile-card-title">Mes annonces</h4> --}}
                
                    {{-- @csrf --}}

                    {{-- @include('dashboard_admin.includes.search_property') --}}
                    <div class="user-profile-card-header-right d-flex">
                        
                                <form action="{{ route('admin.all_properties_premium') }}" method="GET">
                                <input type="hidden" name="type" value="ep">

                                <button type="submit" class="btn btn-sm btn-primary">
                                <i class="far fa-search"></i>
                                Entreprise & Particulier</button>
                            </form>
                            <form action="{{ route('admin.all_properties_premium') }}" method="GET">
                                <input type="hidden" name="type" value="p">
                                
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="far fa-search"></i>
                                    Promoteur</button>

                            </form>

                            <form action="{{ route('admin.all_properties_premium') }}" method="GET">
                                <input type="hidden" name="type" value="c">
                                
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="far fa-search"></i>
                                    Débarras</button>

                            </form>

                            <form action="{{ route('admin.all_properties_premium') }}" method="GET">
                                <input type="hidden" name="type" value="s">
                                
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="far fa-search"></i>
                                    Service</button>

                            </form>

                            {{-- </div>


                        </div> --}}
                    </div>

                

            </div>
            <div class="col-lg-12">
                @if (count($properties) > 0)
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Informations sur les annonces</th>
                                    <th>Utilisateur</th>

                                    <th>Categorie</th>
                                    {{-- <th>Prix</th> --}}
                                    {{-- <th>Views</th>
                                    <th>Status</th> --}}
                                    <th>Views</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($properties as $item)
                                    
                                    <tr>
                                        @if($item->type__ == "property")
                                        @if(!$item->property) @continue @endif

                                        @include("dashboard_admin.property_premium.cast_to_property")

                                        @elseif($item->type__ == "classified")
                                        @if(!$item->classified) @continue @endif

                                        @include("dashboard_admin.property_premium.cast_to_classified")

                                        @elseif($item->type__ == "promoteur_property")
                                        @if(!$item->propertypromoteur) @continue @endif
                                        
                                        @include("dashboard_admin.property_premium.cast_to_property_promoteur")

                                        @elseif($item->type__ == "service")
                                        @if(!$item->service) @continue @endif
                                        @include("dashboard_admin.property_premium.cast_to_service")

                                        @endif
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>

                    
                    {!! $properties->links('vendor.pagination.default') !!}
                @else
                    <p>Pas des annonces</p>
                @endif
            </div>
        </div>
    </div>
    
@endsection
