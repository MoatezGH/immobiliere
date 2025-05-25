@extends('layouts.dashboard')
@section('pageTitle')
    Modifier Un Annonce
@endsection
@section('sectionTitle')
    Modifier Un Annonce
@endsection
@section('content')
    {{-- {{ dd($areasArray) }} --}}
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
            <h4 class="user-profile-card-title">Modifier annonce Ref: {{ $property[0]->ref }} </h4>
            <div class="col-lg-12">
                <div class="post-ad-form">
                    <h6 class="mb-4">Informations de base</h6>
                    <form action="{{ route('update_promoteur_property', $property[0]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Nom de la résidence/lotissement</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Entrez le titre" name="title" value="{{ $property[0]['title'] }}">
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
                                        <option
                                            {{ isset($property[0]['remise_des_clés']) && $property[0]['remise_des_clés'] === 'immediate' ? 'selected' : '' }}
                                            value="immediate">Immediate</option>
                                        <option
                                            {{ isset($property[0]['remise_des_clés']) && $property[0]['remise_des_clés'] === 'dans 6 mois' ? 'selected' : '' }}
                                            value="dans 6 mois">Dans 6 mois</option>
                                        <option
                                            {{ isset($property[0]['remise_des_clés']) && $property[0]['remise_des_clés'] === 'dans 12 mois' ? 'selected' : '' }}
                                            value="dans 12 mois">Dans 12 mois</option>
                                        <option
                                            {{ isset($property[0]['remise_des_clés']) && $property[0]['remise_des_clés'] === 'dans 24 mois' ? 'selected' : '' }}
                                            value="dans 24 mois">Dans 24 mois</option>

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
                                        placeholder="Enter price" value="{{ $property[0]['price_total'] }}"
                                        name="prixtotaol">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'prixtotaol',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix du m²(TND)</label>
                                    <input type="text" class="form-control @error('pricem²') is-invalid @enderror"
                                        placeholder="Enter price" value="{{ $property[0]['price_metre'] }}"
                                        name="price_metre">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'pricem²',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix du m² terrase(TND)</label>
                                    <input type="text" class="form-control @error('pricem²_terass') is-invalid @enderror"
                                        placeholder="Enter price" value="{{ $property[0]['price_metre_terrasse'] }}"
                                        name="pricem²_terass">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'pricem²_terass',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix du m² jardin(TND)</label>
                                    <input type="text" class="form-control @error('pricem²_garden') is-invalid @enderror"
                                        placeholder="Enter price" value="{{ $property[0]['price_metre_jardin'] }}"
                                        name="pricem²_garden">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'pricem²_garden',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix cellier(TND)</label>
                                    <input type="text" class="form-control @error('price_cellier') is-invalid @enderror"
                                        placeholder="Enter price" value="{{ $property[0]['price_cellier'] }}"
                                        name="price_cellier">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'price_cellier',
                                ])
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix place parking(TND)</label>
                                    <input type="text" class="form-control @error('price_parking') is-invalid @enderror"
                                        placeholder="Enter price"
                                        value="{{ $property[0]['price_parking'] }}"name="price_parking">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'price_parking',
                                ])
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="show_price" type="checkbox" value="1"
                                        id="show_price" {{ $property[0]['display_price'] == 1 ? 'checked' : '' }}>
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
                                        placeholder="Enter price" value="{{ $property[0]['surface_totale'] }}"
                                        name="surface_total">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'surface_total',
                                ])
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Surface habitable</label>
                                    <input type="text"
                                        class="form-control @error('surface_habitable') is-invalid @enderror"
                                        placeholder="Enter price" value="{{ $property[0]['surface_habitable'] }}"
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
                                        class="form-control @error('surface_terrasse') is-invalid @enderror"
                                        placeholder="Enter price" value="{{ $property[0]['surface_terrasse'] }}"
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
                                        class="form-control @error('surface_jardin') is-invalid @enderror"
                                        placeholder="Enter price" value="{{ $property[0]['surface_jardin'] }}"
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
                                        placeholder="Enter price" value="{{ $property[0]['surface_cellier'] }}"
                                        name="surface_cellier">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'surface_cellier',
                                ])
                            </div>
                            {{-- <input type="file"  name='test_file' multiple/> --}}
                            <h6 class="fw-bold my-4">Importer des photos</h6>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="product-upload-wrapper">
                                        <div class="product-img-upload">
                                            <span><i class="far fa-images"></i> Télécharger des images de bien</span>
                                        </div>
                                        <input type="file" class="product-img-file" name="photos[]" multiple
                                            onchange="previewImages(event)">

                                        {{-- <input type="hidden" id="imageFiles" name="imageFiles[]" value=""> --}}
                                    </div>

                                </div>
                            </div>
                            {{-- <div class="image-preview" id="imagePreview"></div> --}}
                            <div class="image-preview" id="imagePreview">
                                @foreach ($property[0]->images as $item)
                                    {{-- {{ dd($item) }} --}}
                                    <div class="image-preview-item">
                                        <img src="{{ asset('uploads/promoteur_property/' . $item->title) }}"
                                            alt="" title={{ $item->title }}>
                                        <br>
                                        {{-- <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('delete_image', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE') --}}
                                        {{-- <button type="button" onclick="deleteImage({{ $item->id }})"
                                            class="btn btn-danger btn-sm mt-2">Supprimer</button> --}}
                                        {{-- </form> --}}
                                        {{-- <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('delete_image', ['id' => $item->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE') --}}
                                        <button type="button" onclick="deleteImage({{ $item->id }}) "
                                            class="btn btn-danger btn-sm mt-2">Supprimer</button>
                                        {{-- </form> --}}
                                    </div>
                                @endforeach
                            </div>
                            @include('dasboard_users.properties.include.location')
                            <h6 class="fw-bold my-4">Des informations détaillées</h6>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        placeholder="{{ $property[0]['description'] }}" cols="30" rows="5" name="description">{{ $property[0]['description'] }}
                                    </textarea>
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
                                    <label>Nombre Chambres</label>
                                    {{-- <input type="number" class="form-control" value="{{ $property[0]['nb_bedroom'] }}"
                                        name="room_number"> --}}

                                    <select name="room_number" class="select">
                                        @php
                                            $selectedValue = isset($property[0]['nb_bedroom'])
                                                ? $property[0]['nb_bedroom']
                                                : '';
                                            $maxKitchens = 8; // Maximum number of kitchens (adjust as needed)
                                        @endphp

                                        @for ($i = 0; $i <= $maxKitchens; $i++)
                                            <option value="{{ $i }}"
                                                {{ $selectedValue == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Salons</label>
                                    {{-- <input type="number" class="form-control"
                                        value="{{ $property[0]['nb_living'] }}"name="living_room_number"> --}}

                                    <select name="living_room_number" class="select">
                                        @php
                                            $selectedValue = isset($property[0]['nb_living'])
                                                ? $property[0]['nb_living']
                                                : '';
                                            $maxKitchens = 8; // Maximum number of kitchens (adjust as needed)
                                        @endphp

                                        @for ($i = 0; $i <= $maxKitchens; $i++)
                                            <option value="{{ $i }}"
                                                {{ $selectedValue == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Salle de bains</label>
                                    {{-- <input type="number" class="form-control"
                                        value="{{ $property[0]['nb_bathroom'] }}"name="bath_room_number"> --}}
                                    <select name="bath_room_number" class="select">
                                        @php
                                            $selectedValue = isset($property[0]['nb_bathroom'])
                                                ? $property[0]['nb_bathroom']
                                                : '';
                                            $maxKitchens = 8; // Maximum number of kitchens (adjust as needed)
                                        @endphp

                                        @for ($i = 0; $i <= $maxKitchens; $i++)
                                            <option value="{{ $i }}"
                                                {{ $selectedValue == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Cuisine</label>
                                    <select name="kitchen_number" class="select">
                                        @php
                                            $selectedValue = isset($property[0]['nb_kitchen'])
                                                ? $property[0]['nb_kitchen']
                                                : '';
                                            $maxKitchens = 8; // Maximum number of kitchens (adjust as needed)
                                        @endphp

                                        @for ($i = 0; $i <= $maxKitchens; $i++)
                                            <option value="{{ $i }}"
                                                {{ $selectedValue == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Terrasse</label>
                                    {{-- <input type="number" class="form-control"
                                        value="{{ $property[0]['nb_terrasse'] }}"name="teras_number"> --}}
                                    <select name="teras_number" class="select">
                                        @php
                                            $selectedValue = isset($property[0]['nb_terrasse'])
                                                ? $property[0]['nb_terrasse']
                                                : '';
                                            $options = [
                                                ['value' => '0', 'label' => '0'], // Add an empty option if needed
                                                ['value' => '1', 'label' => '1'],
                                                ['value' => '2', 'label' => '2'],
                                                ['value' => '3', 'label' => '3'],
                                                ['value' => '4', 'label' => '4'],
                                                ['value' => '5', 'label' => '5'],
                                                ['value' => '6', 'label' => '6'],
                                                ['value' => '7', 'label' => '7'],
                                                ['value' => '8', 'label' => '8'],
                                            ];
                                        @endphp

                                        @foreach ($options as $option)
                                            <option value="{{ $option['value'] }}"
                                                {{ $selectedValue == $option['value'] ? 'selected' : '' }}>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Suite Parental</label>
                                    <select name="suite_parental" class="select">
                                        @php
                                            $selectedValue = isset($property[0]['suite_parental'])
                                                ? $property[0]['suite_parental']
                                                : '';
                                            $maxKitchens = 8; // Maximum number of kitchens (adjust as needed)
                                        @endphp

                                        @for ($i = 0; $i <= $maxKitchens; $i++)
                                            <option value="{{ $i }}"
                                                {{ $selectedValue == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Salle D'eau</label>
                                    <select name="sal_eau_number" class="select">
                                        @php
                                            $selectedValue = isset($property[0]['salle_eau'])
                                                ? $property[0]['salle_eau']
                                                : '';
                                            $maxKitchens = 8; // Maximum number of kitchens (adjust as needed)
                                        @endphp

                                        @for ($i = 0; $i <= $maxKitchens; $i++)
                                            <option value="{{ $i }}"
                                                {{ $selectedValue == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Numéro étage</label>
                                    {{-- <input type="number" class="form-control" value="{{ $property[0]['nb_etage'] }}" name="etage"> --}}
                                    <select name="etage" class="select">
                                        @php
                                            $selectedValue = isset($property[0]['nb_etage'])
                                                ? $property[0]['nb_etage']
                                                : '';
                                            $options = [
                                                ['value' => 'rdc', 'label' => 'RDC'],
                                                ['value' => '1', 'label' => '1'],
                                                ['value' => '2', 'label' => '2'],
                                                ['value' => '3', 'label' => '3'],
                                                ['value' => '4', 'label' => '4'],
                                                ['value' => '5', 'label' => '5'],
                                                ['value' => '6', 'label' => '6'],
                                                ['value' => '7', 'label' => '7'],
                                                ['value' => '8', 'label' => '8'],
                                            ];
                                        @endphp

                                        @foreach ($options as $option)
                                            <option value="{{ $option['value'] }}"
                                                {{ $selectedValue == $option['value'] ? 'selected' : '' }}>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>


                            <h4 class="fw-bold my-4">Équipements</h4>
                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="balcon" type="checkbox" value="1"
                                        id="balcon" {{ $property[0]['balcon'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="agree">
                                        Balcon
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="garage" type="checkbox" value="1"
                                        id="garage" {{ $property[0]['garage'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="garage">
                                        Garage
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="parking" type="checkbox" value="1"
                                        id="parking" {{ $property[0]['parking'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="parking">
                                        Parking
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="elevator" type="checkbox" value="1"
                                        id="elevator" {{ $property[0]['ascenseur'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="elevator">
                                        Ascenseur
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="heating" type="checkbox" value="1"
                                        id="heating" {{ $property[0]['heating'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="heating">
                                        Chauffage
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="air_conditioner" type="checkbox"
                                        value="1" id="air_conditioner"
                                        {{ $property[0]['climatisation'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="air_conditioner">
                                        Climatisation
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="alarm_system" type="checkbox" value="1"
                                        id="alarm_system" {{ $property[0]['system_alarm'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="alarm_system">
                                        Système alarme
                                    </label>
                                </div>
                            </div>

                            {{-- <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="wifi" type="checkbox" value="1"
                                        {{ $property[0]['wifi'] == 1 ? 'checked' : '' }} id="wifi">
                                    <label class="form-check-label" for="wifi">
                                        Wifi
                                    </label>
                                </div>
                            </div> --}}

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="swimming_pool" type="checkbox" value="1"
                                        {{ $property[0]['piscine'] == 1 ? 'checked' : '' }} id="swimming_pool">
                                    <label class="form-check-label" for="swimming_pool">
                                        Piscine Privée
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="split" type="checkbox" value="1"
                                        id="split" {{ $property[0]['split'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="split">
                                        Split
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="swimming_pool_public" type="checkbox"
                                        value="1" {{ $property[0]['swimming_pool_public'] == 1 ? 'checked' : '' }}
                                        id="swimming_pool_public">
                                    <label class="form-check-label" for="swimming_pool_public">
                                        Piscine Collective
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="publish_now" type="checkbox" value="1"
                                        id="publish_now" {{ $property[0]['publish_now'] == 1 ? 'checked' : '' }}>
                                    <label style="color:#fc3131" class="form-check-label" for="publish_now">
                                        Publier Maintenant
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12 my-4">
                                <button type="submit" class="theme-btn">Modifier vos annonces</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
    <script>
        let selectedFiles = [];

        function previewImages(event) {
            const preview = document.getElementById('imagePreview');
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                // Validate file type (optional)
                if (!file.type.match('image.*')) {
                    console.error('Only image files are allowed.');
                    continue; // Skip processing this file
                }

                const reader = new FileReader();

                reader.onload = function(e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.classList.add('image-preview-item');
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    imgWrapper.appendChild(img);

                    // const deleteButton = document.createElement('button');
                    // deleteButton.classList.add('delete-button');
                    // deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
                    // deleteButton.addEventListener('click', function() {
                    //     const index = selectedFiles.indexOf(file);
                    //     if (index !== -1) {
                    //         selectedFiles.splice(index, 1);
                    //         imgWrapper.remove();
                    //     }
                    // });
                    // imgWrapper.appendChild(deleteButton);

                    preview.appendChild(imgWrapper);

                    selectedFiles.push(file); // Add file to array for server-side access
                };

                reader.readAsDataURL(file);
            }

            // Clear the input value to allow selecting the same file again
            // event.target.value = '';
        }
    
        function deleteImage(imageId) {
            console.log('first')
            if (confirm('Êtes-vous sûr de vouloir supprimer cette image?')) {
                $.ajax({
                    url: '/delete-image/' + imageId // Corrected the route generation
                    type: 'DELETE',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': imageId // Pass the image ID here
                    },
                    success: function(response) {
                        // Handle success
                        $('#delete-form-' + imageId).closest('.image-preview-item').remove();
                        alert('Image supprimée avec succès');
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                        alert('Une erreur s\'est produite lors de la suppression de l\'image');
                    }
                });
            }
        }
    </script>
@endsection
