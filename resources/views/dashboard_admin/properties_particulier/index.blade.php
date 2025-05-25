@extends('layouts.dashboard')
@section('pageTitle')
    Tous les Annonces Particuliers
@endsection
@section('sectionTitle')
    Tous les Annonces Particuliers
@endsection
@section('content')
    <style>
        .search-form .nice-select {
            height: 45px;
            display: flex;
            align-items: center;
        }

        th,
        h6 {
            font-size: 11px;
        }

        td {
            font-size: 12px;

        }
    </style>
    {{-- {{dd("Particuliers")}} --}}
    {{-- {{dd($usersData )}} --}}
    {{-- @foreach ($users as $item)
    {{dd($item)}}
@endforeach --}}
{{-- {{ dd(Route::current()->getName()) }}  --}}
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

                {{ $props->appends(request()->query())->total() }} Résultats</h6>

            <div class="user-profile-card-header mt-3">
                {{-- <h4 class="user-profile-card-title">Mes annonces</h4> --}}
                <form action="{{ route('all_admin_particulier_property') }}" method="GET">
                    {{-- @csrf --}}
                    @include('dashboard_admin.includes.search_property')
                </form>

            </div>

            {{-- </div> --}}
            <div class="col-lg-12">
                @if (count($props) > 0)
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
                                @foreach ($props as $item)
                                    <tr>
                                        <td>
                                            <div class="table-ad-info">
                                                <a href="#">




                                                    <img src="{{ asset($item->main_picture ? 'uploads/main_picture/images/properties/' . $item->main_picture->alt : 'assets/img/product/01.jpg') }}"
                                                        alt="" style="height: 60px;">
                                                    <div class="table-ad-content">
                                                        <h6>{{ ucfirst(substr($item->title, 0, 10)) }}</h6>
                                                        <small>

                                                            {{ $item->created_at }}
                                                        </small>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ $item->user->userTypeName() }}</td>

                                        <td>{{ ucfirst($item->category->name) }}</td>

                                        <td>{{ $item->count_views }}</td>
                                        <td>
                                            @if ($item->state == 'valid')
                                                <span class="badge badge-success">Active</span>
                                            @elseif ($item->state == 'waiting')
                                                <span class="badge text-bg-warning">En attente</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>

                                            <a href="{{ route('AdminEditProperty', $item->slug) }}"
                                                class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="tooltip"
                                                aria-label="modifier" data-bs-original-title="modifier"><i
                                                    class="far fa-edit"></i></a>

                                            <a href="{{ route('admin_property_info', $item->id) }}" target="__blank"
                                                class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="tooltip"
                                                aria-label="detail" data-bs-original-title="detail"><i
                                                    class="far fa-eye"></i></a>
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
                                                action="{{ route('admin.properties.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                            </form>

                                            <form display="none" id="premium-property-form-{{ $item->id }}"
                                                action="{{ route('admin.store_premium', $item->id) }}" method="POST">
                                                @csrf
                                                
                                                <input type="hidden" name="type" value="property">
                                            </form>

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
