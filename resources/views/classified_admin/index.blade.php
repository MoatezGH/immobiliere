@extends('layouts.dashboard')
@section('pageTitle')
    Tous les Annonces Débarras
@endsection
@section('sectionTitle')
    Tous les Annonces Débarras
@endsection
@section('content')
    <style>
        .search-form nice-select select {
            height: 44px !important;
        }

        .current {
            line-height: 45px !important;
        }

        th,
        h6 {
            font-size: 11px;
        }

        td {
            font-size: 12px;

        }
    </style>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
            <h6 style="display: flex;justify-content: space-between;">Affichage
                {{-- {{ $props->appends(request()->query())->currentPage() }}-{{ $props->appends(request()->query())->perPage() }}
                                à  --}}
                {{ $classifieds->appends(request()->query())->total() }} Résultats
</h6>

            <div class="user-profile-card-header mt-3">

                {{-- <h4 class="user-profile-card-title">Mes annonces</h4> --}}
                <form action="{{ route('admin_classifieds') }}" method="GET">
                    {{-- @csrf --}}
                    @include('dashboard_admin.includes.search_classified')
                </form>

            </div>
            <div class="col-lg-12">
                @if (count($classifieds) > 0)
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Informations sur les annonces</th>
                                    <th>Utilisateur</th>

                                    <th>Categorie</th>
                                    {{-- <th>Prix</th> --}}
                                    <th>Views</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classifieds as $item)
                                    {{-- {{ dd($item->getFirstImageOrDefault() ) }} --}}
                                    <tr>
                                        <td>
                                            <div class="table-ad-info">
                                                <a href="#">

                                                    
                                                    <img src="{{ asset($item->mainPicture ? 'uploads/classified/main_picture/' . $item->mainPicture->picture_path : 'assets/img/product/01.jpg') }}"
                                                        alt="" style="height: 60px;">
                                                    {{-- @endcan --}}

                                                    <div class="table-ad-content">
                                                        <h6>{{ ucfirst(substr($item->title, 0, 10)) }}</h6>
                                                        <span
                                                            style="
                                                    font-size: 13px;
                                                ">{{$item->created_at->format('d/m/y')  }}</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ $item->user->full_name ?? "admin"}}</td>

                                        <td>{{ ucfirst($item->category->name) }}</td>
                                        {{-- <td></td> --}}
                                        {{-- <td>
                                            @can('isAgent')
                                                {{ $item->price }}
                                            @else
                                                {{ $item->price_total }}
                                            @endcan
                                            DT</td> --}}
                                        <td>{{ $item->count_views }}</td>
                                        <td>
                                            @if ($item->status == '1')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge text-bg-warning">En attente</span>
                                            @endif
                                        </td>
                                        <td>
                                            

                                            <a href="{{ route('admin_update_classified', $item->id) }}"
                                                class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="tooltip"
                                                aria-label="Edit" data-bs-original-title="Edit"><i
                                                    class="far fa-pen"></i></a>


                                            <a href="{{ route('classifieds.admin.info', $item->id) }}"
                                                target="__blank" class="btn btn-outline-secondary btn-sm rounded-2"
                                                data-bs-toggle="tooltip" aria-label="detail"
                                                data-bs-original-title="detail"><i class="far fa-eye"></i></a>

                                                <button 
                                                    class="btn btn-outline-warning btn-sm rounded-2" 
                                                    onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de mettre ce annonce premium?')) { document.getElementById('premium-property-form-{{ $item->id }}').submit(); }"
                                                    data-bs-toggle="tooltip"
                                                    aria-label="mettre premium" data-bs-original-title="mettre premium" @if($featuresExist[$item->id]) disabled style="background-color:#ffc107;color:black" @endif><i
                                                        class="far fa-star"></i></button>

                                            <a href="#"
                                                class="btn btn-outline-danger btn-sm rounded-2 delete-property"
                                                data-bs-toggle="tooltip" aria-label="Delete"
                                                onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce annonce?')) { document.getElementById('delete-property-form-{{ $item->id }}').submit(); }"
                                                data-bs-original-title="Delete"><i class="far fa-trash-can"></i></a>

                                            <form display="none" id="delete-property-form-{{ $item->id }}"
                                                action="{{ route('classifieds.destroy.admin', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                            </form>

                                            <form display="none" id="premium-property-form-{{ $item->id }}"
                                                action="{{ route('admin.store_premium', $item->id) }}" method="POST">
                                                @csrf
                                                
                                                <input type="hidden" name="type" value="classified">
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>

                    {{-- {{ $props->links() }} --}}
                    {!! $classifieds->appends(request()->query())->links('vendor.pagination.default') !!}
                @else
                    <p>Pas des annonces</p>
                @endif
            </div>
        </div>
    </div>
    
@endsection
