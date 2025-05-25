@extends('layouts.dashboard')
@section('pageTitle')
    Modifier Un Annonce
@endsection
@section('sectionTitle')
    Modifier Un Annonce
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
    {{-- {{ dd($areas) }} --}}
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
                    <form action="{{ route('update_property', $property[0]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Titre</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        value="{{ $property[0]['title'] }}" placeholder="Entrez le titre" name="title">
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
                                            <option value="{{ $item->id }}"
                                                {{ $property[0]['situation_id'] == $item->id ? 'selected' : '' }}>
                                                {{ ucfirst($item->name) }}</option>
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
                                    <input type="text" class="form-control @error('prixtotaol') is-invalid @enderror"
                                        placeholder="Enter price" name="prixtotaol" value="{{ $property[0]['price'] }}">
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'prixtotaol',
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
                            <div class="image-preview" id="imagePreview">
                                @foreach ($property[0]->pictures as $item)
                                    {{-- {{ dd($item) }} --}}
                                    <div class="image-preview-item" id="p-{{ $item->id }}">
                                        <img src="{{ asset('uploads/new_property/productImage/' . $item->alt) }}"
                                            alt="" title={{ $item->alt }}>
                                        <br>
                                        <div class="d-flex justify-space-between" style="justify-content: space-between;">


                                            <a href="javascript:void(0)" data-url="{{ route('delete_image', $item->id) }}"
                                                data-id="{{ $item->id }}"
                                                class="btn btn-danger btn-sm mt-2 delete-image">
                                                <i class="fa fa-trash" aria-hidden="true">
                                                </i>
                                            </a>

                                            <button type="button"
                                                title="image principale"class="btn btn-success btn-sm mt-2"
                                                style="font-size: 11px;">

                                                Image principale
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @include('dasboard_users.properties.include.location')
                            <h6 class="fw-bold my-4">Des informations détaillées</h6>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Écrire une description"
                                        cols="30" rows="5" name="description">{{ $property[0]['description'] }}</textarea>
                                </div>
                                @include('message_session.error_field_message', [
                                    'fieldName' => 'description',
                                ])
                            </div>
                            {{-- <h4 class="fw-bold my-4">Superficie</h4>
                            <h6>Superficie couverte</h6>
                            <br> --}}
                            <h4 class="fw-bold my-2">Superficie</h4>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Superficie Total</label>
                                    <input type="number" class="form-control" value="{{ $property[0]['floor_area'] }}"
                                        name="floor_area">
                                </div>
                            </div>
                            {{-- <h6 class="fw-bold my-2">Superficie Couverte</h6> --}}
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Superficie Couverte</label>
                                    <input type="number" class="form-control" value="{{ $property[0]['plot_area'] }}"
                                        name="plot_area">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Chambres</label>
                                    <input type="number" class="form-control" value="{{ $property[0]['room_number'] }}"
                                        name="room_number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Salons</label>
                                    <input type="number" class="form-control"
                                        value="{{ $property[0]['living_room_number'] }}" name="living_room_number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Salle de bains</label>
                                    <input type="number" class="form-control"
                                        value="{{ $property[0]['bath_room_number'] }}" name="bath_room_number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Cuisine</label>
                                    <input type="number" class="form-control"
                                        value="{{ $property[0]['kitchen_number'] }}" name="kitchen_number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre Terrasse</label>
                                    <input type="number" class="form-control" value="{{ $property[0]['terrace'] }}"
                                        name="teras_number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Numéro étage</label>
                                    <input type="number" class="form-control" value="{{ $property[0]['etage'] }}"
                                        name="etage">
                                </div>
                            </div>


                            <h4 class="fw-bold my-4">Équipements</h4>
                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="balcon" type="checkbox" value="1"
                                        id="balcon" {{ $property[0]['balcony'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="agree">
                                        Balcon
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="garden" type="checkbox" value="1"
                                        id="garden" {{ $property[0]['garden'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="garden">
                                        Jardin
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
                                        id="elevator" {{ $property[0]['elevator'] == 1 ? 'checked' : '' }}>
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
                                        {{ $property[0]['air_conditioner'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="air_conditioner">
                                        Climatisation
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="alarm_system" type="checkbox" value="1"
                                        id="alarm_system" {{ $property[0]['alarm_system'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="alarm_system">
                                        Système alarme
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="wifi" type="checkbox" value="1"
                                        {{ $property[0]['wifi'] == 1 ? 'checked' : '' }} id="wifi">
                                    <label class="form-check-label" for="wifi">
                                        Wifi
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="swimming_pool" type="checkbox" value="1"
                                        {{ $property[0]['swimming_pool'] == 1 ? 'checked' : '' }} id="swimming_pool">
                                    <label class="form-check-label" for="swimming_pool">
                                        Piscine
                                    </label>
                                </div>
                            </div>


                            <div class="col-lg-12 my-4">
                                <button type="submit" class="theme-btn">Publiez vos annonces</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                };

                reader.readAsDataURL(file);
            }

            // Clear the input value to allow selecting the same file again
            // event.target.value = '';
        }


        // function deleteImage(imageId) {
        //     if (confirm('Êtes-vous sûr de vouloir supprimer cette image?')) {
        //         $.ajax({
        //             url: '/delete-image/' + imageId,
        //             type: 'DELETE',
        //             data: {
        //                 '_token': '{{ csrf_token() }}',
        //                 'id': imageId
        //             },
        //             success: function(response) {
        //                 // Handle success
        //                 console.log("teeeee")
        //                 $('#delete-form-' + imageId).closest('.image-preview-item').remove();
        //                 alert('Image deleted successfully');
        //             },
        //             error: function(xhr, status, error) {
        //                 // Handle errors
        //                 console.log(error)
        //                 console.error(xhr.responseText);
        //                 alert('Une erreur s\'est produite lors de la suppression de l\'image');
        //             }
        //         });
        //     }
        // }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    // 'X-CSRF-TOKEN': $('input[name="_token"]').value()
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.delete-image', function() {
                // console.log(document.getElementsByName('_token').value)

                var userURL = $(this).data('url');
                var trObj = $(this);
                var imageId = $(this).data('id');
                console.log(imageId)
                if (confirm("Êtes-vous sûr de vouloir supprimer cette image?") == true) {
                    $.ajax({
                        url: userURL,
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(data) {
                            //alert(data.success);
                            // console.log($('#p' + imageId))
                            $('#p-' + imageId).remove();
                        }
                    });
                }

            });

        });
    </script>
@endsection
