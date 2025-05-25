@extends('layouts.dashboard')
@section('pageTitle')
    Tous les Stores
@endsection
@section('sectionTitle')
    Tous les Stores
@endsection
@section('content')
    {{-- {{dd("enter")}} --}}

    <style>
        .search-form .nice-select {
            height: 45px;
            display: flex;
            align-items: center;
        }

        td,
        th,
        h6 {
            font-size: 11px;
        }

        /* .search-form .nice-select .list{
                                                                                                                width: auto;

                                                                                                            } */
    </style>

{{-- {{ dd(Route::current()->getName()) }} --}}

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

                {{ $stores->appends(request()->query())->total() }} Résultats</h6>

            <div class="user-profile-card-header mt-3">
                {{-- <h4 class="user-profile-card-title">Mes annonces</h4> --}}
                <form action="{{ route('admin.stores') }}" method="GET">
                    {{-- @csrf --}}

                    @include('dashboard_admin.includes.search_store')


                </form>

            </div>
            <div class="col-lg-12">
                @if (count($stores) > 0)
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nom de store</th>
                                    <th>Utilisateur</th>

                                    <th>Categorie</th>
                                    {{-- <th>Prix</th> --}}
                                    <th>Views</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stores as $item)
                                    {{-- {{ dd($item->main_picture->alt) }} --}}
                @if(!$item->user) 
@continue
@endif

                                    <tr>
                                        <td>
                                            <div class="table-ad-info">
                                                <a href="#">
                                                    {{-- <img src="{{ asset($item->main_picture ? 'uploads/main_picture/images/properties/' . $item->main_picture->alt : 'assets/img/product/01.jpg') }}"
                                                        alt="" style="height: 60px;"> --}}


                                                        <img src="{{ asset('uploads/store_logos/' . $item->logo) }}"
                                                        alt="" style="height: 40px;width: 40px;">

                                                    <div class="table-ad-content">
                                                        <h6>{{ ucfirst($item->store_name) }}</h6>


                                                        <span style="font-size: 10px;">
                                                            {{-- <small>

                                                                {{ $item->created_at }}
                                                            </small> --}}


                                                        </span>

                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td> {{ $item->user->username}}
                                        </td>
                                        <td>{{ ucfirst($item->type) }}</td>
                                        <td>{{ $item->nb_view ?? 0 }}</td>


                                        {{-- <td>
                                            @can('isAgent')
                                                {{ $item->price }}
                                            @else
                                                {{ $item->price_total }}
                                            @endcan
                                            DT</td> --}}
                                        {{-- <td>{{ $item->count_views }}</td> --}}
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                            <a 
                                                class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="tooltip"
                                                aria-label="detail" 
                                                onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir bloquer ce store?')) { document.getElementById('inactive-store-form-{{ $item->id }}').submit(); }"
                                                data-bs-original-title="Bloqué"><i
                                                    class="far fa-ban"></i></a>
                                                    @else
                                                    <a  
                                                    class="btn btn-outline-success btn-sm rounded-2" data-bs-toggle="tooltip"
                                                    aria-label="detail" 
                                                    onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir activé ce store?')) { document.getElementById('active-store-form-{{ $item->id }}').submit(); }"
                                                    data-bs-original-title="Activer"><i
                                                        class="fas fa-check"></i></a>

                                                    @endif

                                            <form display="none" id="active-store-form-{{ $item->id }}"
                                                action="{{ route('admin.active.store', $item->id) }}" method="POST">
                                                @csrf
                                                {{-- @method('DELETE') --}}

                                            </form>
                                            <form display="none" id="inactive-store-form-{{ $item->id }}"
                                                action="{{ route('admin.inactive.store', $item->id) }}" method="POST">
                                                @csrf

                                            </form>

                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>

                    {{-- {{ $props->links() }} --}}
                    {!! $stores->links('vendor.pagination.default') !!}
                @else
                    <p>Pas des stores</p>
                @endif
            </div>
        </div>
    </div>
    {{-- <script>
        document.querySelectorAll('.delete-property').forEach(function(deleteButton) {
            deleteButton.addEventListener('click', function(event) {
                event.preventDefault();
                var confirmation = confirm('Are you sure you want to delete this property?');
                if (confirmation) {
                    var formId = this.dataset.formId;
                    document.getElementById('delete-property-form-' + {{ $item->id }}).submit();
                }
            });
        });
    </script> --}}
@endsection
