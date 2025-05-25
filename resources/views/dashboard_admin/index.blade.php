@extends('layouts.dashboard')
@section('pageTitle')
Tableau de bord
@endsection
@section('content')
<!-- breadcrumb -->
<!-- user-profile -->
{{-- {{ dd($property_pending) }} --}}

<div class="user-profile-wrapper">
    <div class="row">
        <!-- annonce -->
        <h4>Toutes Les Annonces</h4>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget dashboard-widget-color-1">
                <div class="dashboard-widget-info">
                    <h1> {{ $property_promoteur < 1000 ? $property_promoteur : number_format($property_promoteur / 1000, 1) . 'k' }}
                    </h1>
                    <span>Annonces Promoteurs</span>
                </div>
                <div class="dashboard-widget-icon">
                    <i class="fal fa-list"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget dashboard-widget-color-1">
                <div class="dashboard-widget-info">
                    <h1>{{ $property_particulier < 1000 ? $property_particulier : number_format($property_particulier / 1000, 1) . 'k' }}
                    </h1>
                    <span>Annonces Particuliers</span>
                </div>
                <div class="dashboard-widget-icon">
                    <i class="fal fa-layer-group"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget dashboard-widget-color-1">
                <div class="dashboard-widget-info">
                    <h1> {{ $property_company < 1000 ? $property_company : number_format($property_company / 1000, 1) . 'k' }}
                    </h1>
                    <span>Annonces Companies</span>
                </div>
                <div class="dashboard-widget-icon">
                    <i class="fal fa-layer-group"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6">
            <div class="dashboard-widget dashboard-widget-color-1">
                <div class="dashboard-widget-info">
                    <h1> {{ $all_classified < 1000 ? $all_classified : number_format($all_classified / 1000, 1) . 'k' }}
                    </h1>
                    <span>Annonces Débarras</span>
                </div>
                <div class="dashboard-widget-icon">
                    <i class="fal fa-layer-group"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6">
            <div class="dashboard-widget dashboard-widget-color-1">
                <div class="dashboard-widget-info">
                    <h1> {{ $all_services < 1000 ? $all_services : number_format($all_services / 1000, 1) . 'k' }}
                    </h1>
                    <span>Annonces Services</span>
                </div>
                <div class="dashboard-widget-icon">
                    <i class="fal fa-layer-group"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
    <div class="dashboard-widget dashboard-widget-color-3">
        <div class="dashboard-widget-info">
            <h1>{{ $property_pending < 1000 ? $property_pending : number_format($property_pending / 1000, 1) . 'k' }}</h1>

            <span>Annonces En Attente</span>
        </div>
        <div class="dashboard-widget-icon">
            <i class="fal fa-eye-slash"></i>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-6">
    <div class="dashboard-widget dashboard-widget-color-3">
        <div class="dashboard-widget-info">
            <h1>{{ $property_promoteur_pending < 1000 ? $property_promoteur_pending : number_format($property_promoteur_pending / 1000, 1) . 'k' }}</h1>

            <span>Annonces Promoteur Att</span>
        </div>
        <div class="dashboard-widget-icon">
            <i class="fal fa-eye-slash"></i>
        </div>
    </div>
</div>


<div class="col-md-6 col-lg-6">
    <div class="dashboard-widget dashboard-widget-color-3">
        <div class="dashboard-widget-info">
            <h1>{{ $classified_pending < 1000 ? $classified_pending : number_format($classified_pending / 1000, 1) . 'k' }}</h1>

            <span>Annonces Débarras Att</span>
        </div>
        <div class="dashboard-widget-icon">
            <i class="fal fa-eye-slash"></i>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-6">
    <div class="dashboard-widget dashboard-widget-color-3">
        <div class="dashboard-widget-info">
            <h1>{{ $service_pending < 1000 ? $service_pending : number_format($service_pending / 1000, 1) . 'k' }}</h1>

            <span>Annonces Services Att</span>
        </div>
        <div class="dashboard-widget-icon">
            <i class="fal fa-eye-slash"></i>
        </div>
    </div>
</div>

        <!-- end annonce -->
<hr>
    </div>
    <div class="row">
    <h4>Tous Les Utilisateurs</h4>

        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget dashboard-widget-color-2">
                <div class="dashboard-widget-info">
                    <h1>

                        {{ $users < 1000 ? $users : number_format($users / 1000, 1) . 'k' }}
                    </h1>
                    <span>Utilisateur</span>
                </div>
                <div class="dashboard-widget-icon">
                    <i class="fal fa-users"></i>
                </div>
            </div>
        </div>
        <!-- user classified -->
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget dashboard-widget-color-2">
                <div class="dashboard-widget-info">
                    <h1>
                        {{ $classifiedusers < 1000 ? $classifiedusers : number_format($classifiedusers / 1000, 1) . 'k' }}

                    </h1>
                    <span>Utilisateur Débarras</span>
                </div>
                <div class="dashboard-widget-icon">
                    <i class="fal fa-users"></i>
                </div>
            </div>
        </div>
        <!-- service users -->
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget dashboard-widget-color-2">
                <div class="dashboard-widget-info">
                    <h1>
                        {{ $serviceusers < 1000 ? $serviceusers : number_format($serviceusers / 1000, 1) . 'k' }}

                    </h1>
                    <span>Utilisateur Service</span>
                </div>
                <div class="dashboard-widget-icon">
                    <i class="fal fa-users"></i>
                </div>
            </div>
        </div>
<hr>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget dashboard-widget-color-3">
                <div class="dashboard-widget-info">
                    <h1>{{ $sliders }}</h1>

                    <span>Sliders</span>
                </div>
                <div class="dashboard-widget-icon">
                    <i class="fal fa-image"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-widget dashboard-widget-color-3">
                <div class="dashboard-widget-info">
                    <h1>{{ $ads }}</h1>

                    <span>Publicité</span>
                </div>
                <div class="dashboard-widget-icon">
                    <i class="fal fa-ad"></i>
                </div>
            </div>
        </div>






</div>
</div>

<!-- user-profile end -->




@endsection