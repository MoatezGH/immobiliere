{{-- {{ dd($classifieds) }} --}}
@extends('layouts.dashboard_classified')
@section('pageTitle')
    Tous les Annonces
@endsection
@section('sectionTitle')
    Tous les Annonces
@endsection
@section('content')
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
            <div class="user-profile-card-header">
                <h4 class="user-profile-card-title">Mes annonces</h4>
                <form action="{{ route('index_classified') }}" method="GET">
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
                @if (count($classifieds) > 0)
                    <div class="table-responsive">
                        <table class="table text-nowrap"
                            style="
                        /* width: 36%; */
                        font-size: 13px;
                    ">
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
                                @foreach ($classifieds as $item)
                                    {{-- {{ dd($item->main_picture->alt) }} --}}
                                    <tr>
                                        <td>
                                            <div class="table-ad-info">
                                                <a href="#">


                                                    <img src="{{ asset($item->mainPicture ? 'uploads/classified/main_picture/' . $item->mainPicture->picture_path : 'assets/img/product/01.jpg') }}"
                                                        alt="" style="height: 60px;">


                                                    <div style="white-space: normal;"class="table-ad-content">
                                                        <h6>{{ ucfirst(substr($item->title, 0, 10)) }}</h6>
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
                                        <td>{{ $item->created_at->format('d/m/y') }}</td>
                                        <td>

                                            {{ $item->price }}

                                            DT</td>
                                        <td>0</td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                {{-- <p>test</p> --}}
                                                <span class="badge text-bg-warning">En attente</span>
                                            @endif

                                        </td>

                                        <td>

                                            @if ($item->remonter != true)
                                                <form action="{{ route('classified.remonter', $item->id) }}" method="POST"
                                                    style="display: contents;">
                                                    @csrf
                                                    {{-- <button type="submit">Mettre en avant</button> --}}
                                                    <button type="submit"
                                                        style="background: #198754;
                                                            color: white;"
                                                        class="btn btn-outline-success btn-sm rounded-2 "
                                                        data-bs-toggle="tooltip" aria-label="remonter"
                                                        data-bs-original-title="remonter"><i class="far fa-r"></i></button>


                                                    <input type="hidden" name="type" value="debaras">

                                                </form>
                                            @endif
                                            <a href="{{ route('update_classified', $item->id) }}"
                                                class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="tooltip"
                                                aria-label="Edit" data-bs-original-title="Edit"><i
                                                    class="far fa-pen"></i></a>
                                            <a href="{{ route('show_update_images', $item->id) }}"
                                                class="btn btn-outline-success btn-sm rounded-2" data-bs-toggle="tooltip"
                                                aria-label="Edit" data-bs-original-title="Modifier images"><i
                                                    class="far fa-image"></i></a>
                                            <a href="#"
                                                class="btn btn-outline-danger btn-sm rounded-2 delete-property"
                                                data-bs-toggle="tooltip" aria-label="Supprimer"
                                                onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce annonce?'))  { document.getElementById('delete-classified-form-{{ $item->id }}').submit(); }"
                                                data-bs-original-title="Supprimer"><i class="far fa-trash-can"></i></a>

                                            <form display="none" id="delete-classified-form-{{ $item->id }}"
                                                action="{{ route('classifieds.destroys', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

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
