@extends('layouts.dashboard')
@section('pageTitle')
    Tableau de bord
@endsection
@section('content')
    {{-- {{ dd($propsViewtot) }} --}}
    <!-- breadcrumb -->
    <!-- user-profile -->

    {{-- {{Route::current()->getName() }} --}}
    <div class="user-profile-wrapper">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="dashboard-widget dashboard-widget-color-1">
                    <div class="dashboard-widget-info">
                        <h1>{{ $propstotActive }}</h1>
                        <span style="font-size: 15px">Nombre total <br> d'annonces en ligne</span>
                    </div>
                    <div class="dashboard-widget-icon">
                        <i class="fal fa-list"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="dashboard-widget dashboard-widget-color-2">
                    <div class="dashboard-widget-info">
                        <h1>{{ $propsViewtot < 1000 ? $propsViewtot : number_format($propsViewtot / 1000, 1) . 'k' }}</h1>

                        <span style="font-size: 15px">Nombre total <br> d'annonces consultées</span>
                    </div>
                    <div class="dashboard-widget-icon">
                        <i class="fal fa-eye"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="dashboard-widget dashboard-widget-color-3">
                    <div class="dashboard-widget-info">
                        <h1>{{ $propstot }}</h1>
                        <span style="font-size: 15px">Nombre total <br> d'annonces publiées</span>
                    </div>
                    <div class="dashboard-widget-icon">
                        <i class="fal fa-layer-group"></i>
                    </div>
                </div>
            </div>
            {{-- new card --}}

            <div class="col-md-6 col-lg-4">
                <a href="{{ route('display_number_ip') }}">

                    <div class="dashboard-widget dashboard-widget-color-3"
                        style="    background-color: #adf659;;
                        color: black;">
                        <div class="dashboard-widget-info">
                            <h1 style="    
                            color: black;">
                                {{ $displayed_number < 1000 ? $displayed_number : number_format($displayed_number / 1000, 1) . 'k' }}
                            </h1>
                            <span style="font-size: 15px">Nombre des visiteurs <br> ayant affichées le numéro</span>
                        </div>
                        <div class="dashboard-widget-icon"
                            style="    background-color: white;
                            color: #7ae202;">
                            <i class="fal fa-mobile"></i>
                        </div>
                    </div>
                </a>


            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('call_number_ip') }}">
                <div class="dashboard-widget dashboard-widget-color-3"
                    style="    background-color: #FF9800;
                            color: black;">
                    <div class="dashboard-widget-info">
                        <h1 style="    
                        color: black;">
                            {{ $call < 1000 ? $call : number_format($call / 1000, 1) . 'k' }}</h1>
                        <span style="font-size: 15px">Nombre des visiteurs <br> ayant effectués un appel</span>
                    </div>
                    <div class="dashboard-widget-icon"
                        style="    background-color: white;
                    color: #FF9800">
                        <i class="fal fa-volume-control-phone"></i>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('send_email_ip') }}">
                <div class="dashboard-widget dashboard-widget-color-3"
                    style="    background-color: #00BCD4;
                        color: black;">
                    <div class="dashboard-widget-info">
                        <h1 style="    
                        color: black;">
                            {{ $mail < 1000 ? $mail : number_format($mail / 1000, 1) . 'k' }}</h1>
                        <span style="font-size: 15px">Nombre des visiteurs<br>ayant envoyés un message</span>
                    </div>
                    <div class="dashboard-widget-icon"
                        style="    background-color: white;
                    color: #00BCD4">
                        <i class="fal fa-envelope"></i>
                    </div>
                </div>
                </a>
            </div>
            {{-- end new card --}}
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="user-profile-card">
                    <h4 class="user-profile-card-title">
                        Annonces récentes
                    </h4>
                    <div class="table-responsive">
                        @if (count($props) > 0)
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Informations sur les annonces</th>
                                        <th>Categorie</th>
                                        <th>Publier</th>
                                        <th>Prix</th>
                                        <th>Views</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($props as $item)
                                        <tr>
                                            <td>
                                                <div class="table-ad-info">
                                                    <a href="#">
                                                        {{-- <img src="{{ asset($item->main_picture ? 'uploads/main_picture/images/properties/' . $item->main_picture->alt : 'assets/img/product/01.jpg') }}"
                                                            alt="" style="height: 60px;"> --}}

                                                        @can('isAgent')
                                                            <img src="{{ asset($item->main_picture ? 'uploads/main_picture/images/properties/' . $item->main_picture->alt : 'assets/img/product/01.jpg') }}"
                                                                alt="" style="height: 60px;">
                                                        @else
                                                            <img src="{{ asset($item->getFirstImageOrDefault() ? 'uploads/promoteur_property/' . $item->getFirstImageOrDefault() : 'assets/img/product/01.jpg') }}"
                                                                alt="" style="height: 60px;">
                                                        @endcan
                                                        <div class="table-ad-content">
                                                            <h6>
                                                                {{ ucfirst(substr($item->title, 0, 20)) }}
                                                            </h6>
                                                            <span>Réf:
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
                                                @endcan DT
                                            </td>
                                            <td>{{ $item->count_views }}</td>
                                            <td>
                                                {{-- @if ($item->state == 'valid')
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif --}}
                                                @can('isAgent')
                                                    @if ($item->state == 'valid')
                                                        <span class="badge badge-success">Active</span>
                                                    @elseif ($item->state == 'waiting')
                                                        {{-- <p>test</p> --}}
                                                        <span class="badge text-bg-warning">En attente</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                @else
                                                    @if ($item->status == 1)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge text-bg-warning">En attente</span>
                                                    @endif
                                                @endcan
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Pas des annonces</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- user-profile end -->
@endsection
