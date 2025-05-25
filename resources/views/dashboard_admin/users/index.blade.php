@extends('layouts.dashboard')
@section('pageTitle')
    Tous les Utilisateur
@endsection
@section('sectionTitle')
    Tous les Utilisateur
@endsection
@section('content')
    <style>
        .search-form .nice-select {
            height: 45px;
            display: flex;
            align-items: center;
        }
    </style>
{{-- {{ dd(request()->type) }} --}}


    {{-- <div class="col-lg-9"> --}}
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
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

                {{ $users->appends(request()->query())->total() }} Résultats</h6>

            <div class="user-profile-card-header mt-2">
                <form action="{{ route('all_users_admin') }}" method="GET"
                    style="
                                            display: flex;
                                            justify-content: space-between;
                                            width: -webkit-fill-available;
                                        ">
                    {{-- @csrf --}}

                    <div class="user-profile-search search-form ">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Cherche..." name="search"
                                value="{{ isset(request()->search) ? request()->search : '' }}">
                            <i class="far fa-search"></i>



                        </div>


                    </div>
                    {{-- <div class="user-profile-search search-form ">
                    <div class="form-group">
                        <select class=" select" aria-label="Default select example" name="user_id">
                            <option value="">Choisir Statut</option>
                            <option value="1">Acitve</option>
                            <option value="0">Inactive</option>



                        </select>
                        <i class="far fa-bars-sort"></i>




                    </div>


                </div> --}}
                    <div class="user-profile-search search-form">
                        <div class="form-group">
                            <input type="date" class="form-control" name="date">
                            <i class="far fa-calendar"></i>

                        </div>


                    </div>
                    <div class="user-profile-search search-form">

                        <div class="form-group ">
                            <select class=" select" aria-label="Default select example" name="status">
                                <option value="" {{ request()->status = null ? 'selected' : '' }}>Tous Status</option>

                                {{-- @foreach ($users as $item) --}}
                                <option value="1" {{ request()->status == 1 ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ request()->status == 0 ? 'selected' : '' }}>Inactive
                                </option>
                                {{-- @endforeach --}}
                            </select>
                            <i class="far fa-bars-sort"></i>



                        </div>


                    </div>

                    {{-- type --}}
                    <div class="user-profile-search search-form">

                        <div class="form-group ">
                            <select class=" select" aria-label="Default select example" name="type">
                                <option value="" {{ request()->type = null ? 'selected' : '' }}>Tous Utilisateurs</option>

                                {{-- @foreach ($users as $item) --}}
                                <option value="promoteur" {{ request()->type == "promoteur" ? 'selected' : '' }}>Promoteur
                                </option>
                                
                                <option value="entreprise" {{ request()->type == "entreprise" ? 'selected' : '' }}>Entreprise
                                </option>
                                <option value="particulier" {{ request()->type == "particulier" ? 'selected' : '' }}>Particulier
                                </option>
                                {{-- @endforeach --}}
                            </select>
                            <i class="far fa-user"></i>



                        </div>


                    </div>
                    <button type="submit" class="theme-btn"><span class="far fa-search"></span></button>
                </form>
            </div>


        </div>
        <div class="col-lg-12">
            @if (count($users) > 0)
                <div class="table-responsive" style="
                font-size: 10px;
            ">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                {{-- <th>Informations sur les Utilisateurs</th> --}}
                                <th>Nom & Prénom</th>

                                <th>Email</th>
                                <th>Phone</th>
                                <th>Category</th>
                                <th>Dernière connexion</th>
                                <th>Date</th>

                                <th>Statut</th>
                                

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                            {{-- {{ dd($item) }} --}}
                                <tr>
                                    <td>
                                        {{ $item->userTypeName() ?? '' }}
                                    </td>
                                    <td>
                                        <div class="table-ad-info">
                                            {{-- <a href="#"> --}}
                                            {{ $item->email }}
                                            {{-- </a> --}}
                                        </div>
                                    </td>

                                    <td>{{ $item->userPhone2() }} </td>
                                    <td>
                                        @php
                                            $usType = $item->checkType();
                                            switch ($usType) {
                                                case 'company':
                                                    $usertype = 'Entreprise';
                                                    break;
                                                case 'particular':
                                                    $usertype = 'Particulier';
                                                    break;

                                                default:
                                                    $usertype = 'Promoteur';

                                                    break;
                                            }
                                        @endphp
                                        {{ $usertype }}
                                    </td>
                                    <td>{{ $item->last_login }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>

                                    <td>
                                        @if ($item->enabled == '1')
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($item->enabled == 1)
                                            <a class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="tooltip"
                                                aria-label="detail"
                                                onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir bloquer ce utilisateur?')) { document.getElementById('block-user-form-{{ $item->id }}').submit(); }"
                                                data-bs-original-title="Bloqué"><i class="far fa-ban"></i></a>
                                        @else
                                            <a class="btn btn-outline-info btn-sm rounded-2" data-bs-toggle="tooltip"
                                                aria-label="detail"
                                                onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir activé ce utilisateur?')) { document.getElementById('active-user-form-{{ $item->id }}').submit(); }"
                                                data-bs-original-title="Activer"><i class="fab fa-angellist"></i></a>
                                        @endif

                                        <a href="#" class="btn btn-outline-danger btn-sm rounded-2 delete-property"
                                            data-bs-toggle="tooltip" aria-label="Delete"
                                            onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce utilisateur?')) { document.getElementById('delete-user-form-{{ $item->id }}').submit(); }"
                                            data-bs-original-title="supprimer"><i class="far fa-trash-can"></i>
                                        </a>
                                        {{-- new --}}
                                        <a href="{{ route('admin.stat.user.index',['id' => $item->id, 'userType' => $usertype]
                                        ) }}"
                                            class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="tooltip"
                                            aria-label="statistique" data-bs-original-title="statistique"><i
                                                class="far fa-bar-chart"></i>
                                            </a>



                                            @if($item->access_to_publish == 0)
                                            <a href="#" class="btn btn-outline-warning btn-sm rounded-2 access-share-property"
                                            data-bs-toggle="tooltip" aria-label="publier sur {{env('DEUXIEM_SITE')}}"
                                            onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de donner accés pour publier?')) { document.getElementById('access-share-user-form-{{ $item->id }}').submit(); }"
                                            data-bs-original-title="publier sur {{env('DEUXIEM_SITE')}}">
                                            <i class="far fa-share"></i>
                                            </a>
                                            @else
                                            <a href="#" class="btn btn-outline-warning btn-sm rounded-2 access-share-property" 
                                            data-bs-toggle="tooltip" aria-label="publier sur {{env('DEUXIEM_SITE')}}"
                                            onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de bloquer accés pour publier??')) { document.getElementById('access-share-user-form-{{ $item->id }}').submit(); }"
                                            data-bs-original-title="publier sur {{env('DEUXIEM_SITE')}}" 
                                            style="background-color:#ffc107;color:black"
                                            >
                                            <i class="far fa-share"></i>
                                            </a>
                                            @endif

                                            {{-- end new --}}

                                        <form display="none" id="delete-user-form-{{ $item->id }}"
                                            action="{{ route('users.delete', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                        </form>
                                        <form display="none" id="access-share-user-form-{{ $item->id }}"
                                            action="{{ route('users_give_access', $item) }}" method="POST">
                                            @csrf

                                            
                                        </form>
                                        <form display="none" id="block-user-form-{{ $item->id }}"
                                            action="{{ route('users.disable', $item) }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="type" value="property">
                                        </form>

                                        <form display="none" id="active-user-form-{{ $item->id }}"
                                            action="{{ route('users.active', $item) }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="type" value="property">
                                        </form>
                                        
                                    </td>


                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>


                {!! $users->appends(request()->query())->links('vendor.pagination.default') !!}
            @else
                <p>Aucun Utilisateur</p>
            @endif
        </div>
    </div>
    </div>
@endsection
