@extends('layouts.dashboard')
@section('pageTitle')
    Ajouter Un Débarras
@endsection
@section('sectionTitle')
    Ajouter Un Débarras
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

        .addresss{
            display:none !important;
        }
    </style>
{{-- {{ dd($categories) }} --}}
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
            <h4 class="user-profile-card-title">Publier annonce</h4>
            <div class="col-lg-12">
                <div class="post-ad-form">
                    {{-- <h6 class="mb-4">Informations de base</h6> --}}
                    <form action="{{ route('admin_store_classified2') }}" method="POST">
                        @csrf
                        {{-- <div class="row align-items-center"> --}}
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Titre

                                        @include("includes.required")

                                    </label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Entrez le titre" name="title" value="{{ old('title') }}"
                                        maxlength="34" required>
                                </div>

                            </div>
                            @include('message_session.error_field_message', [
                                'fieldName' => 'title',
                            ])


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Catégorie

                                        @include("includes.required")

                                    </label>
                                    <select class="select @error('categorie_id') is-invalid @enderror" name="categorie_id" required>
                                        <option value="">Choisir catégorie</option>
                                        @foreach ($categories as $category )
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            
                                        @endforeach


                                    </select>
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'categorie_id',
                                ])
                            </div>



                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix (TND)

                                        @include("includes.required")

                                    </label>
                                    <input type="number" min="0"
                                        class="form-control @error('price') is-invalid @enderror" placeholder=""
                                        name="price" value="{{ old('price') }}" required>
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'price',
                                ])
                            </div>

                            @include('dasboard_users.properties.include.location')
                            <hr>

                            <div class="col-lg-4">
                                <label>Vous étes un</label>

                                <div class="form-group">
                                    {{-- <div class="d-flex p-1" style=" justify-content: space-between"> --}}
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="type_annonceur" value="0"
                                                type="radio" role="switch" id="type_annonceur-1" checked="">
                                            <label class="form-check-label" for="type_annonceur-1">Particulier</label>


                                        </div>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="type_annonceur" value="1"
                                                type="radio" role="switch" id="type_annonceur-2" checked="">
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
                                <label>Type</label>

                                <div class="form-group">
                                    {{-- <div class="d-flex p-1" style=" justify-content: space-between"> --}}
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="type_product" value="0"
                                                type="radio" role="switch" id="type_product-1" checked="">
                                            <label class="form-check-label" for="type_product-1">Vente</label>


                                        </div>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="type_product" value="1"
                                                type="radio" role="switch" id="type_product-2" checked="">
                                            <label class="form-check-label" for="type_product-2">Don</label>


                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="type_product" value="2"
                                                type="radio" role="switch" id="type_product-3" checked="">
                                            <label class="form-check-label" for="type_product-3">Avis de recherche</label>


                                        </div>
                                    {{-- </div> --}}
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'prixtotaol',
                                ])
                            </div>
                            {{-- <hr> --}}

                            {{-- Etat --}}
                            <div class="col-lg-4">
                                <label>État de produit</label>

                                <div class="form-group">
                                    {{-- <div class="d-flex p-1"> --}}
                                        @foreach ($types as $item)
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="condition_product" value="{{ $item->id }}"
                                                type="radio" role="switch" id="condition_product-{{ $item->id }}" checked="">
                                            <label class="form-check-label" for="condition_product-{{ $item->id }}">{{ $item->name }}</label>


                                        </div>
                                        @endforeach
                                    {{-- </div> --}}
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'prixtotaol',
                                ])
                            </div>

                            {{-- <h6 class=" my-4">Des informations détaillées</h6> --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description
                                        @include("includes.required")

                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Écrire une description"
                                        cols="30" rows="5" name="description" >{{ old('description') }}</textarea>
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'description',
                                ])
                            </div>
                            @include('includes.publish_to_immo')


                            @include('includes.champ_obligatoir')
                            <div class="col-lg-12 my-4 align-items-center d-flex">
                                <button style="margin-right: 6px" type="submit" class="theme-btn mr-2">Publier & ajouter des images</button>

                                {{-- <a href="" style="    background-color: transparent;
                                color: #004aad;
                                border: 1px solid #004aad;" class="theme-btn">Publier & ajouter des images </a> --}}
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
