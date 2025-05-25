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
                    <form action="{{ route('strore_property') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Titre</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Entrez le titre" name="title" value="{{ old('title') }}"
                                        maxlength="34">
                                </div>

                            </div>
                            @include('message_session.error_field_message', [
                                'fieldName' => 'title',
                            ])
                            @include('dasboard_users.properties.include.operation')

                            @include('dasboard_users.properties.include.property_type')

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Situation</label>
                                    <select class="select @error('situation_id') is-invalid @enderror" name="situation_id">
                                        <option value="">Choisir situation</option>

                                        @foreach ($situations as $item)
                                            <option value="{{ $item->id }}">{{ ucfirst($item->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'situation_id',
                                ])
                            </div>



                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Prix (TND)</label>
                                    <input type="number" min="0" class="form-control @error('prixtotaol') is-invalid @enderror"
                                        placeholder="" name="prixtotaol">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'prixtotaol',
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
                            {{-- @include('dasboard_users.properties.include.upload_image')
                            
                            <div class="image-preview" id="imagePreview"></div>
                             --}}
                             @include('dasboard_users.properties.include.location')
                            <h6 class=" my-4">Des informations détaillées</h6>
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
                            <h6 class=" my-4">Caractéristiques</h6>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Superficie Total</label>
                                    <input type="number" min="0" class="form-control" value="0" name="floor_area" >
                                </div>
                            </div>
                            {{-- <h6 class=" my-2">Superficie Couverte</h6> --}}
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Superficie Couverte</label>
                                    <input type="number" min="0" class="form-control" value="0" name="plot_area" >
                                </div>
                            </div>
                            {{-- <br> --}}
                            {{-- <h6></h6> --}}

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Chambres</label>
                                    <input type="number" min="0" class="form-control" value="0" name="room_number" >
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Salons</label>
                                    <input type="number" min="0" class="form-control" value="0" name="living_room_number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Salle de bains</label>
                                    <input type="number" min="0" class="form-control" value="0" name="bath_room_number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Cuisine</label>
                                    <input type="number" min="0" class="form-control" value="0" name="kitchen_number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Terrasse</label>
                                    <input type="number" min="0" class="form-control" value="0" name="teras_number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Numéro étage</label>
                                    <input type="number" min="0" class="form-control" value="0" name="etage">
                                </div>
                            </div>


                            <h6 class=" my-4">Équipements</h6>
                            <div class="col-6 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" name="balcon" type="checkbox" value="1"
                                        id="balcon">
                                    <label class="form-check-label" for="agree">
                                        Balcon
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" name="garden" type="checkbox" value="1"
                                        id="garden">
                                    <label class="form-check-label" for="garden">
                                        Jardin
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" name="garage" type="checkbox" value="1"
                                        id="garage">
                                    <label class="form-check-label" for="garage">
                                        Garage
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" name="parking" type="checkbox" value="1"
                                        id="parking">
                                    <label class="form-check-label" for="parking">
                                        Parking
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" name="elevator" type="checkbox" value="1"
                                        id="elevator">
                                    <label class="form-check-label" for="elevator">
                                        Ascenseur
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" name="heating" type="checkbox" value="1"
                                        id="heating">
                                    <label class="form-check-label" for="heating">
                                        Chauffage
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" name="air_conditioner" type="checkbox"
                                        value="1" id="air_conditioner">
                                    <label class="form-check-label" for="air_conditioner">
                                        Climatisation
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" name="alarm_system" type="checkbox" value="1"
                                        id="alarm_system">
                                    <label class="form-check-label" for="alarm_system">
                                        Système alarme
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" name="wifi" type="checkbox" value="1"
                                        id="wifi">
                                    <label class="form-check-label" for="wifi">
                                        Wifi
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" name="swimming_pool" type="checkbox" value="1"
                                        id="swimming_pool">
                                    <label class="form-check-label" for="swimming_pool">
                                        Piscine
                                    </label>
                                </div>
                            </div>
                            <hr>

                            <div class="col-6 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" name="publish_now" type="checkbox" value="1"
                                        id="publish_now">
                                    <label class="form-check-label" for="publish_now">
                                        Publier maintenant
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12 my-4">
                                <button type="submit" class="theme-btn">Publier </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
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
                    ////
                    const delWrapper = document.createElement('div');
                    delWrapper.classList.add('d-flex', 'justify-content-between');
                    // Create delete button
                    const deleteButton = document.createElement('button');
                    deleteButton.classList.add('btn', 'btn-danger',
                        'btn-sm',
                        'mt-2');

                    // deleteButton.textContent = 'Supprimer';
                    deleteButton.innerHTML = '<i class="fa fa-trash" aria-hidden="true"></i>';
                    deleteButton.addEventListener('click', function() {
                        preview.removeChild(imgWrapper); // Remove image preview
                        selectedFiles = selectedFiles.filter(selectedFile => selectedFile !==
                            file); // Remove file from selectedFiles array
                    });
                    delWrapper.appendChild(deleteButton);
                    imgWrapper.appendChild(delWrapper);

                    preview.appendChild(imgWrapper);

                    selectedFiles.push(file); // Add file to array for server-side access
                    // console.log(selectedFiles)
                };

                reader.readAsDataURL(file);
            }
        }
    </script> --}}
@endsection
