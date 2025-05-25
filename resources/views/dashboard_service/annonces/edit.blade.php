@extends('layouts.dashboard_service')
@section('pageTitle')
    Modifier Un Service
@endsection
@section('sectionTitle')
    Modifier Un Service
@endsection
@section('content')
    <style>
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .image-preview-item {
            position: relative;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .image-preview-item img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .delete-button {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(254, 7, 7, 0.7);
            border: none;
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }
    </style>
    {{-- {{ dd($service) }} --}}
    {{-- <div class="col-lg-9"> --}}
    <div class="user-profile-wrapper">
        <div class="user-profile-card">
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
            <h4 class="user-profile-card-title">Modifier votre service</h4>
            <div class="col-lg-12">
                <div class="post-ad-form">
                    {{-- <h6 class="mb-4">Informations de base</h6> --}}
                    <form action="{{ route('service.update',$service->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        {{-- <div class="row align-items-center"> --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Titre
                                    @include("includes.required")

                                    </label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Entrez le titre" required name="title"
                                        value="{{ $service->title }}" maxlength="34">
                                </div>

                            </div>
                            @include('message_session.error_field_message', [
                                'fieldName' => 'title',
                            ])


                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Catégorie
                                    @include("includes.required")

                                    </label>
                                    <select class="select @error('categorie_id') is-invalid @enderror" name="categorie_id"
                                        required>
                                        <option value="">Choisir catégorie</option>
                                        @foreach ($categories as $category)
                                            <option @if ($service->category_id == $category->id) selected @endif
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach


                                    </select>
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'categorie_id',
                                ])
                            </div>



                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Service</label>
                                    <input type="text" class="form-control @error('service') is-invalid @enderror"
                                        placeholder="Entrez le service" name="service" value="{{ $service->service }}">
                                </div>

                            </div>

                            <h6 class=" my-4">Zone d'activité principale</h6>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Ville
                                    @include("includes.required")

                                    </label>
                                    <select class="select  @error('city_id') is-invalid @enderror" style="display: none;"
                                        name="city_id" id="citySelect">
                                        <option value="">Choisir une ville</option>

                                        @foreach ($cities as $item)
                                            <option value="{{ $item->id }}"
                                                {{ isset($service->city_id) && $service->city_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @include('message_session.error_field_message', [
                                    'fieldName' => 'city_id',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Autre Zones d'activité </label>
                                    <input type="text" name="work_zone" value="{{ $service->work_zone }}" class="form-control">
                                </div>
                            </div>
                            
                            <hr>

                            <div class="col-lg-4">
                                <label>Vous étes un:</label>

                                <div class="form-group">
                                    {{-- <div class="d-flex p-1" style=" justify-content: space-between"> --}}
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="type_annonceur" value="0" type="radio"
                                            role="switch" id="type_annonceur-1"
                                            @if ($service->annonceur_type == 0) checked @endif>
                                        <label class="form-check-label" for="type_annonceur-1">Particulier</label>


                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="type_annonceur" value="1" type="radio"
                                            role="switch" id="type_annonceur-2"
                                            @if ($service->annonceur_type == 1) checked @endif>
                                        <label class="form-check-label" for="type_annonceur-2">Professionnel</label>


                                    </div>
                                    {{-- </div> --}}
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'type_annonceur',
                                ])
                            </div>
                            {{-- type --}}
                            <div class="col-lg-4">
                                <label>Type:</label>

                                <div class="form-group">
                                    {{-- <div class="d-flex p-1" style=" justify-content: space-between"> --}}
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="type_product" value="1" type="radio"
                                            role="switch" id="type_product-1"
                                            @if ($service->type == 1) checked @endif>
                                        <label class="form-check-label" for="type_product-1">Offre de service</label>


                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="type_product" value="2" type="radio"
                                            role="switch" id="type_product-2"
                                            @if ($service->type == 2) checked @endif>
                                        <label class="form-check-label" for="type_product-2">Avis de recherche</label>


                                    </div>
                                    
                                    {{-- </div> --}}
                                </div>
                                {{-- @include('message_session.error_field_message', [
                                    'type_product' => 'prixtotaol',
                                ]) --}}
                            </div>
                            {{-- <hr> --}}

                            {{-- Etat --}}
                            <div class="col-lg-4">
                                <label>Facilité de paiement:</label>

                                <div class="form-group">
                                    {{-- <div class="d-flex p-1"> --}}
                                    @foreach ($type_payement as $item)
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="paiement_type"
                                                @if ($service->paiement_type == $item->id) checked @endif
                                                value="{{ $item->id }}" type="radio" role="switch"
                                                id="paiement_type-{{ $item->id }}">
                                            <label class="form-check-label"
                                                for="paiement_type-{{ $item->id }}">{{ ucfirst($item->name) }}</label>


                                        </div>
                                    @endforeach
                                    {{-- </div> --}}
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'paiement_type',
                                ])
                            </div>

                            {{-- <h6 class=" my-4">Des informations détaillées</h6> --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Écrire une description"
                                        cols="30" rows="5" name="description">{{ $service->description }}</textarea>
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'description',
                                ])
                            </div>
                            <div class="col-lg-12 my-4 align-items-center d-flex">
                                <button style="margin-right: 6px" type="submit" class="theme-btn mr-2">Modifier</button>

                                {{-- <a href="" style="    background-color: transparent;
                                color: #fc3131;
                                border: 1px solid #fc3131;" class="theme-btn">Publier & ajouter des images </a> --}}
                            </div>

                            {{-- <div class="col-lg-12 my-4">
                               
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
