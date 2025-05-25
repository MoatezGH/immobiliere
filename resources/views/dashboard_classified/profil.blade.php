@extends('layouts.dashboard_classified')

@section('pageTitle')
    Compte
@endsection

@section('sectionTitle')
    Mon compte
@endsection

@section('content')
    {{-- {{ dd($user) }} --}}
    <div class="user-profile-wrapper">
        <div class="row">

            <div class="col-lg-7">
                <div class="user-profile-wrapper">
                    <div class="user-profile-card">
                        <h4 class="user-profile-card-title">Informations de compte</h4>
                        <div class="col-lg-12">
                            <div class="post-ad-form">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session()->has('success_profile'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success_profile') }}
                                    </div>
                                @endif
                                {{-- <h6 class="mb-4">Basic Information</h6> --}}
                                <form action="{{ route('updateProfileClassified') }}" method="POST">
                                    @csrf
                                    <div class="row align-items-center">
                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label>
                                                    Nom & Prénom
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->full_name }}" name="full_name">
                                            </div>
                                            @if ($errors->has('full_name'))
                                                <p class="text-danger">
                                                    {{ $errors->first('full_name') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->email }}" placeholder="Email" name="email">
                                            </div>
                                            @if ($errors->has('Email'))
                                                <p class="text-danger">
                                                    {{ $errors->first('Email') }}
                                                </p>
                                            @endif
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Téléphone mobile</label>
                                                <input type="text" class="form-control" value="{{ $user->phone }}"
                                                    placeholder="+216 55 000 000" name="mobile" onkeypress="return isNumberKey(event)">
                                            </div>
                                            @if ($errors->has('phone'))
                                                <p class="text-danger">
                                                    {{ $errors->first('phone') }}
                                                </p>
                                            @endif
                                        </div>

                                        

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Ville</label>
                                                <select class="select" name="city_id" id="citySelect">
                                                    <option value="">Choissir une ville</option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ $user->country_id == $city->id ? 'selected' : '' }}>
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('city_id'))
                                                <p class="text-danger">
                                                    {{ $errors->first('city_id') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group" id="area_div">
                                                <label>Région</label>
                                                <select class="select" name="area_id" id="areaSelect">
                                                    <option value="">Choissir une région</option>
                                                    @foreach ($areas as $area)
                                                        <option
                                                            {{ $user->city_id == $area->id ? 'selected' : '' }}
                                                            value="{{ $area->id }}">{{ $area->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            @if ($errors->has('area_id'))
                                                <p class="text-danger">
                                                    {{ $errors->first('area_id') }}
                                                </p>
                                            @endif
                                        </div>


                                        

                                    </div>
                                    <button type="submit" class="theme-btn my-3"><span class="far fa-user"></span>
                                        Sauvegarder</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>


            {{-- {{ dd($logo) }} --}}

            @include('dashboard_classified.includes.change_password_account')
            <form action="{{ route('updateProfileClassified') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12">
                    <div class="user-profile-card profile-store">
                        {{-- <h4 class="user-profile-card-title">Informations sur le Shop</h4> --}}
                        <div class="col-lg-12">
                            @if ($errors->has('store'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('store') }}
                                </div>
                            @endif
                            @if (session()->has('success_store'))
                                <div class="alert alert-success">
                                    {{ session()->get('success_store') }}
                                </div>
                            @endif
                            <div class="user-profile-form">
                                <form action="#">
                                    <div class="form-group">

                                        <div class="store-logo-preview">
                                            
                                                {{-- {{ dd('eeeeeeeee') }} --}}
                                                <img src="{{ asset($user->logo ? 'uploads/user_classifed_logos/' . $user->logo : 'assets/img/store/01.jpg') }}"
                                                    alt="Store Logo">

                                        </div>
                                        <input type="file" class="store-file store-file-log store-file" name="logo">
                                        @if ($errors->has('logo'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('logo') }}
                                            </div>
                                        @endif
                                        <button type="button" class="theme-btn store-upload-logo"
                                            onclick="handleImageUpload('.store-upload-logo', '.store-logo-preview img', '.store-file-log')">

                                            <span class="far fa-upload"></span> Télécharger le logo</button>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>lien Facebook</label>
                                                <input type="text"
                                                    class="form-control @error('fb_link') is-invalid @enderror"
                                                    placeholder="https://www.facebook.com" name="fb_link"
                                                    value="{{ $user->fb_link ?? '' }}">
                                            </div>
                                            @if ($errors->has('fb_link'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('fb_link') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>lien de site Web</label>
                                                <input type="text" name="site_web_link"
                                                    class="form-control @error('site_web_link') is-invalid @enderror"
                                                    placeholder="https://www.site-web.com"
                                                    @if ($errors->has('site_web_link')) autofocus @endif
                                                    value="{{ $user->site_web_link ?? '' }}">

                                                @if ($errors->has('site_web_link'))
                                                    <div class="alert alert-danger">
                                                        {{ $errors->first('site_web_link') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="theme-btn my-3"><span class="far fa-save"></span>
                                        Sauvegarder
                                        Changements</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function handleImageUpload(buttonSelector, previewSelector, fileInputSelector) {
            // console.log("eeeee")
            const button = document.querySelector(buttonSelector);
            const preview = document.querySelector(previewSelector);
            const fileInput = document.querySelector(fileInputSelector);
            // const type = document.getElementById("type_user").value;

            // console.log("b "+button)
            // console.log("pre "+preview)
            // console.log("fil "+fileInput)
            // console.log("ty "+type)
            fileInput.click();
            // button.addEventListener('click', function() {
            //     fileInput.click();
            // });
            // console.log("test100")
            fileInput.addEventListener('change', function(event) {
                // console.log("test200")
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        preview.src = event.target.result;
                    };
                    // console.log("test")
                    // console.log("1")

                    if (button.className === "profile-img-btn") {
                        // console.log("first")
                        preview.style.display = "block !important";
                        preview.style.width = '100px'; // Set desired width
                        preview.style.height = '100px'; // Set desired height
                        preview.style.backgroundImage = `url(${event.target.result})`;
                        preview.style.backgroundSize = 'cover';
                        sendFileToController(file, type);
                        // reader.readAsDataURL(file);


                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        function sendFileToController(file, type) {
            const formData = new FormData();
            formData.append("file", file);
            formData.append("type_user", type); // Assuming your server expects the file as 'file'
            // Assuming your server expects the file as 'file'
            // console.log('send');
            // const csrfToken = document.getElemen;
            const csrfToken = document.querySelector('input[name="_token"]').value;
            // console.log(csrfToken)
            // console.log('stop');

            formData.append("_token", csrfToken);

            fetch("/change_logo", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest" // Inform server it's an AJAX request
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // return response.json(); // Assuming your server sends a JSON response
                        location.reload();
                    } else {
                        throw new Error("Server error");
                    }
                    // console.log("Server response:", response);

                })

                .catch(error => {
                    // console.error("Error:", error);
                    // Handle errors (network errors, server errors, etc.)
                });
        }

        // Call the function for each upload section
        // handleImageUpload('.store-upload-logo', '.store-logo-preview img', '.store-file-log');
        // handleImageUploadProfile('.profile-img-btn', '.user-profile-img img', '.profile-img-file');

        // handleImageUpload('.store-upload-banner', '.store-banner-preview img', '.store-file-banner');
    </script>

    <script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode == 43 || (charCode >= 48 && charCode <= 57))
            return true;
        return false;
    }
</script>
@endsection
