@extends('layouts.dashboard')
@section('pageTitle')
    Ajouter Un Annonce
@endsection
@section('sectionTitle')
    Ajouter Un Annonce
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
            <h4 class="user-profile-card-title">Publier des annonces</h4>
            <div class="col-lg-12">
                <div class="post-ad-form">
                    <h6 class="mb-4">Informations de base</h6>
                    <form action="{{ route('promoteur_store_property') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Nom de la résidence/lotissement</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Entrez le titre" name="title" value="{{ old('title') }}"
                                        maxlength="34" required>
                                </div>

                            </div>
                            @include('message_session.error_field_message', [
                                'fieldName' => 'title',
                            ])
                            @include('dasboard_users.properties.include.operation')

                            @include('dasboard_users.properties.include.property_type')

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Remises des clés</label>
                                    {{-- <select class="select @error('situation_id') is-invalid @enderror" name="situation_id">
                                        <option value="">Choisir situation</option>

                                        @foreach ($situations as $item)
                                            <option value="{{ $item->id }}">{{ ucfirst($item->name) }}</option>
                                        @endforeach
                                    </select> --}}
                                    <select class="select" name="remise_des_clés">
                                        <option value="">Remise des clés</option>
                                        <option value="immediate">Immediate</option>
                                        <option value="dans 6 mois">Dans 6 mois</option>
                                        <option value="dans 12 mois">Dans 12 mois</option>
                                        <option value="dans 24 mois">Dans 24 mois</option>

                                    </select>
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'situation_id',
                                ])
                            </div>

                            <h6 class="fw-bold my-4">Prix</h6>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix total(TND)</label>
                                    <input type="text" class="form-control @error('prixtotaol') is-invalid @enderror"
                                        placeholder="" name="prixtotaol" required>
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'prixtotaol',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix du m²(TND)</label>
                                    <input type="text" class="form-control @error('pricem²') is-invalid @enderror"
                                        placeholder="" name="pricem²">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'pricem²',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix du m² terrase(TND)</label>
                                    <input type="text" class="form-control @error('pricem²_terass') is-invalid @enderror"
                                        placeholder="" name="pricem²_terass">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'pricem²_terass',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix du m² jardin(TND)</label>
                                    <input type="text" class="form-control @error('pricem²_garden') is-invalid @enderror"
                                        placeholder="" name="pricem²_garden">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'pricem²_garden',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix cellier(TND)</label>
                                    <input type="text" class="form-control @error('price_cellier') is-invalid @enderror"
                                        placeholder="" name="price_cellier">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'price_cellier',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix place parking(TND)</label>
                                    <input type="text" class="form-control @error('price_parking') is-invalid @enderror"
                                        placeholder="" name="price_parking">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'price_parking',
                                ])
                            </div>
                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="show_price" type="checkbox" value="1"
                                        id="show_price">
                                    <label class="form-check-label" for="show_price">
                                        Afficher prix
                                    </label>
                                </div>
                            </div>
                            <h6 class="fw-bold my-4">Surface</h6>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Surface total</label>
                                    <input type="text" class="form-control @error('surface_total') is-invalid @enderror"
                                        placeholder="" name="surface_total" required>
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'surface_total',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Surface habitable</label>
                                    <input type="text"
                                        class="form-control @error('surface_habitable') is-invalid @enderror" placeholder=""
                                        name="surface_habitable">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'surface_habitable',
                                ])
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Surface terrasse</label>
                                    <input type="text"
                                        class="form-control @error('surface_terrasse') is-invalid @enderror" placeholder=""
                                        name="surface_terrasse">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'surface_terrasse',
                                ])
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Surface jardin</label>
                                    <input type="text"
                                        class="form-control @error('surface_jardin') is-invalid @enderror" placeholder=""
                                        name="surface_jardin">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'surface_jardin',
                                ])
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Surface cellier</label>
                                    <input type="text"
                                        class="form-control @error('surface_cellier') is-invalid @enderror"
                                        placeholder="" name="surface_cellier">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'surface_cellier',
                                ])
                            </div>
                            
                            
                            @include('dasboard_users.properties.include.location')
                            <h6 class="fw-bold my-4">Des informations détaillées</h6>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Écrire une description"
                                        cols="30" rows="5" name="description"></textarea>
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'description',
                                ])
                            </div>
                            <h4 class="fw-bold my-4">Caractéristiques</h4>
                            {{-- <h6>Superficie couverte</h6> --}}
                            <br>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Numéro étage</label>
                                    <select name="etage" class="select">
                                        <option value="rdc">RDC</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                    {{-- <input type="number" class="form-control" value="0" name="etage"> --}}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Chambres</label>
                                    {{-- <input type="number" class="form-control" value="0" name="room_number"> --}}
                                    <select name="room_number" class="select">
                                        <option value="0">0</option>

                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Salons</label>
                                    <select name="living_room_number" class="select">
                                        <option value="0">0</option>

                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                    {{-- <input type="number" class="form-control" value="0" name="living_room_number"> --}}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Salle de bains</label>
                                    <select name="bath_room_number" class="select">
                                        <option value="0">0</option>

                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                    {{-- <input type="number" class="form-control" value="0" name="bath_room_number"> --}}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Cuisine</label>
                                    <select name="kitchen_number" class="select">
                                        <option value="1">Équipé</option>

                                        <option value="0">Non équipé</option>

                                    </select>
                                    {{-- <input type="number" class="form-control" value="0" name="kitchen_number"> --}}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Salle D'eau</label>
                                    <select name="sal_eau_number" class="select">
                                        <option value="0">0</option>

                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                    {{-- <input type="number" class="form-control" value="0" name="kitchen_number"> --}}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Terrasse</label>
                                    <select name="teras_number" class="select">
                                        <option value="0">0</option>


                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                    {{-- <input type="number" class="form-control" value="0" name="teras_number"> --}}
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Suite Parental</label>
                                    <select name="suite_parental" class="select">
                                        <option value="0">0</option>


                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                    {{-- <input type="number" class="form-control" value="0" name="teras_number"> --}}
                                </div>
                            </div>


                            {{-- ameneties --}}
                            <h4 class="fw-bold my-4">Équipements</h4>
                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="balcon" type="checkbox" value="1"
                                        id="balcon">
                                    <label class="form-check-label" for="agree">
                                        Balcon
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="swimming_pool" type="checkbox" value="1"
                                        id="swimming_pool">
                                    <label class="form-check-label" for="swimming_pool">
                                        Piscine Privée
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="garage" type="checkbox" value="1"
                                        id="garage">
                                    <label class="form-check-label" for="garage">
                                        Garage
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="parking" type="checkbox" value="1"
                                        id="parking">
                                    <label class="form-check-label" for="parking">
                                        Parking
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="elevator" type="checkbox" value="1"
                                        id="elevator">
                                    <label class="form-check-label" for="elevator">
                                        Ascenseur
                                    </label>
                                </div>
                            </div>
                            {{-- <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="garden" type="checkbox" value="1"
                                        id="garden">
                                    <label class="form-check-label" for="garden">
                                        Jardin
                                    </label>
                                </div>
                            </div> --}}


                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="heating" type="checkbox" value="1"
                                        id="heating">
                                    <label class="form-check-label" for="heating">
                                        Chauffage
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="split" type="checkbox" value="1"
                                        id="split">
                                    <label class="form-check-label" for="split">
                                        Split
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="alarm_system" type="checkbox" value="1"
                                        id="alarm_system">
                                    <label class="form-check-label" for="alarm_system">
                                        Système alarme
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="air_conditioner" type="checkbox"
                                        value="1" id="air_conditioner">
                                    <label class="form-check-label" for="air_conditioner">
                                        Climatisation Central
                                    </label>
                                </div>
                            </div>



                            {{-- <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="wifi" type="checkbox" value="1"
                                        id="wifi">
                                    <label class="form-check-label" for="wifi">
                                        Wifi
                                    </label>
                                </div>
                            </div> --}}

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="swimming_pool_public" type="checkbox"
                                        value="1" id="swimming_pool_public">
                                    <label class="form-check-label" for="swimming_pool_public">
                                        Piscine Collective
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="col-10 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="publish_now" type="checkbox" value="1"
                                        id="publish_now">
                                    <label style="color:#fc3131" class="form-check-label" for="publish_now">
                                        Publier Maintenant
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12 my-4">
                                <button type="submit" class="theme-btn">Publier</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
@endsection
