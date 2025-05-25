@extends('layouts.dashboard')
@section('pageTitle')
    Tous les Annonces
@endsection
@section('sectionTitle')
    Tous les Annonces
@endsection
@section('content')
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
            <div class="user-profile-card-header">
                <h4 class="user-profile-card-title">Mes annonces</h4>
                <form
                    @can('isAgent')
                            action="{{ route('all_user_property') }}"
                        @else
                            action="{{ route('all_promoteur_property') }}" 
                        @endcan
                    method="GET">
                    <div class="user-profile-card-header-right">

                        <div class="user-profile-search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Cherche..." name="keywords"
                                    value="{{ isset($searchTerm) ? $searchTerm : '' }}">
                                <i class="far fa-search"></i>

                            </div>
                            {{-- <a href="{{ route('get_add_property') }}" class="theme-btn"><i class="far fa-search"></i></a> --}}

                        </div>

                        <button type="submit" class="theme-btn"><span class="far fa-search"></span></button>
                    </div>
                </form>

            </div>
            <div class="col-lg-12">
                @if (count($props) > 0)
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Informations sur les annonces</th>
                                    <th>Catégorie</th>
                                    <th>Publier</th>
                                    <th>Prix</th>
                                    <th>Views</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($props as $item)
                                    {{-- {{ dd($item->main_picture->alt) }} --}}
                                    <tr>
                                        <td>
                                            <div class="table-ad-info">
                                                <a href="#">

                                                    @can('isAgent')
                                                        <img src="{{ asset($item->main_picture ? 'uploads/main_picture/images/properties/' . $item->main_picture->alt : 'assets/img/product/01.jpg') }}"
                                                            alt="" style="height: 60px;">
                                                    @else
                                                        <img src="{{ asset($item->getFirstImageOrDefault() ? 'uploads/promoteur_property/' . $item->getFirstImageOrDefault() : 'assets/img/product/01.jpg') }}"
                                                            alt="" style="height: 60px;">
                                                    @endcan

                                                    <div class="table-ad-content">
                                                        <h6>{{ ucfirst(substr($item->title, 0, 20)) }}</h6>
                                                        <span
                                                            style="
                                                    font-size: 13px;
                                                ">Réf:
                                                            {{ $item->ref }}</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ ucfirst($item->category->name) }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @can('isAgent')
                                                {{ $item->price }}
                                            @else
                                                {{ $item->price_total }}
                                            @endcan
                                            DT</td>
                                        <td>{{ $item->count_views }}</td>
                                        <td>
                                            @can('isAgent')
                                                @if ($item->state == 'valid')
                                                    <span class="badge badge-success">Active</span>
                                                @elseif ($item->state == 'waiting')
                                                    {{-- <p>test</p> --}}
                                                    <span class="badge text-bg-warning">En attente</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                                {{-- @if ($item->state == 'valid')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif --}}
                                            @else
                                                @if ($item->status == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge text-bg-warning">En attente</span>
                                                @endif
                                            @endcan

                                        </td>
                                        <td>
                                            {{-- <a href="#" class="btn btn-outline-secondary btn-sm rounded-2"
                                            data-bs-toggle="tooltip" aria-label="Details"
                                            data-bs-original-title="Details"><i class="far fa-eye"></i></a> --}}
                                            <a @can('isAgent')
                                                            href="{{ route('EditProperty', $item->slug) }}"
                                                        @else
                                                            href="{{ route('EditPropertyPromoteur', $item->slug) }}"
                                                        @endcan
                                                class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="tooltip"
                                                aria-label="Edit" data-bs-original-title="Edit"><i
                                                    class="far fa-pen"></i></a>
                                                    @can('isAgent')
                                            <a href="#"
                                                class="btn btn-outline-danger btn-sm rounded-2 delete-property"
                                                data-bs-toggle="tooltip" aria-label="Supprimer"
                                                onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce annonce?'))  { document.getElementById('delete-property-form-{{ $item->id }}').submit(); }"
                                                data-bs-original-title="Supprimer"><i class="far fa-trash-can"></i></a>

                                            <form display="none" id="delete-property-form-{{ $item->id }}"
                                                action="{{ route('properties.destroy', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                            </form>

                                            @else
                                            <a href="#"
                                                class="btn btn-outline-danger btn-sm rounded-2 delete-property"
                                                data-bs-toggle="tooltip" aria-label="Supprimer"
                                                onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce annonce?'))  { document.getElementById('delete-property-promoteur-form-{{ $item->id }}').submit(); }"
                                                data-bs-original-title="Supprimer"><i class="far fa-trash-can"></i></a>

                                            <form display="none" id="delete-property-promoteur-form-{{ $item->id }}"
                                                action="{{ route('property.promotuer.destroy', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                            </form>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>

                    {{-- {{ $props->links() }} --}}
                    {!! $props->appends(request()->query())->links('vendor.pagination.default') !!}
                @else
                    <p>Pas des annonces</p>
                @endif
            </div>
        </div>
    </div>
@endsection
