@extends('layouts.dashboard')
@section('pageTitle')
    Statistique
@endsection
@section('content')
    {{-- {{ dd($id) }} --}}
    <!-- breadcrumb -->
    <!-- user-profile -->
    <div class="user-profile-wrapper">
        <div class="row">
            {{-- new card --}}

            <div class="col-md-6 col-lg-4">
                <a href="{{ route('admin.stat.user.display_number',$id) }}">

                    <div class="dashboard-widget dashboard-widget-color-3"
                        style="    background-color: #adf659;;
                color: black;">
                        <div class="dashboard-widget-info">
                            <h1 style="    
                        color: black;">
                                {{ $displayed_number < 1000 ? $displayed_number : number_format($displayed_number / 1000, 1) . 'k' }}
                            </h1>
                            <span style="font-size: 15px">Nombre des visiteurs <br> ayant afichées le numéro</span>
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
                <a href="{{ route('admin.stat.user.call',$id) }}">
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
                <a href="{{ route('admin.stat.user.mail',$id) }}">
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
        </div>
        
    </div>

    <!-- user-profile end -->
@endsection
