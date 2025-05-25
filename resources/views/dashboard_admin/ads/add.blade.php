@extends('layouts.dashboard')
@section('pageTitle')
    Ajouter Un Slider
@endsection
@section('sectionTitle')
    Ajouter Un Slider
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
            @if ($errors->has('adError'))
                <div class="alert alert-danger">
                    {{ $errors->first('adError') }}
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <h4 class="user-profile-card-title">Ajouter Publicité</h4>
            <div class="col-lg-12">
                <div class="post-ad-form">
                    {{-- <h6 class="mb-4">Informations de base</h6> --}}
                    <form action="{{ route('admin.store_ad') }}" method="POST" enctype="multipart/form-data">
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

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Lien</label>
                                    <input type="text" class="form-control " placeholder="Entrez le titre" name="lien"
                                        value="{{ old('lien') }}">
                                </div>

                            </div>

                            {{-- @include('dasboard_users.properties.include.upload_image')
                            <div class="image-preview" id="imagePreview"></div> --}}

                            <h6 class=" my-4">Importer photo </h6>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="product-upload-wrapper">
                                        <div class="product-img-upload main_pic">
                                            <span onclick="open_main()"><i class="far fa-images"></i> Télécharger image
                                                </span>
                                        </div>
                                        <input type="file" class="product-img-file product-img-file-main"
                                            name="photos_main" id="open_main" onchange="previewMainPicture(event)">
                                    </div>
                                </div>
                                <div class="col-lg-12" id="mainPicturePreview" style="display: none;">
                                    <img id="mainPicturePreviewImg" src="#" alt="Main Picture Preview"
                                        style="max-width: 100%; max-height: 300px;">
                                </div>
                                <div class="col-6 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="publish_now" type="checkbox" value="1"
                                        id="publish_now">
                                    <label class="form-check-label" for="publish_now">
                                        Publier maintenant
                                    </label>
                                </div>
                            </div>
                            </div>

                            <div class="col-lg-12 my-4">
                                <button type="submit" class="theme-btn">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function open_main(event) {
        // event.previewDefault();
        console.log('first1')
        const button = document.getElementById('open_main');
        button.click();
    }

    function previewMainPicture(event) {
        const input = event.target;
        const preview = document.getElementById('mainPicturePreviewImg');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                document.getElementById('mainPicturePreview').style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    </script>
@endsection
