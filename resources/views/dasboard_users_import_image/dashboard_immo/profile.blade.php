@extends('layouts.dashboard')

@section('pageTitle')
    Compte
@endsection

@section('sectionTitle')
    Mon compte
@endsection

@section('content')
    {{-- {{ dd($userAccount) }} --}}
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
                                <form action="{{ route('updateProfile') }}" method="POST">
                                    @csrf
                                    <div class="row align-items-center">
                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label>
                                                    @if (auth()->user()->isCompany())
                                                        Raison social (Nom entreprise)
                                                    @else
                                                        Nom & Prénom
                                                    @endif
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ auth()->user()->username }}" name="username">
                                            </div>
                                            @if ($errors->has('username'))
                                                <p class="text-danger">
                                                    {{ $errors->first('username') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="text" class="form-control"
                                                    value="{{ auth()->user()->email }}" placeholder="Email" name="email">
                                            </div>
                                            @if ($errors->has('Email'))
                                                <p class="text-danger">
                                                    {{ $errors->first('Email') }}
                                                </p>
                                            @endif
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Téléphone mobile</label>
                                                <input type="text" class="form-control" value="{{ $userType->mobile ?? "" }}"
                                                    placeholder="+216 55 000 000" name="mobile" onkeypress="return isNumberKey(event)">
                                            </div>
                                            @if ($errors->has('mobile'))
                                                <p class="text-danger">
                                                    {{ $errors->first('mobile') }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Téléphone fixe</label>
                                                <input type="text" class="form-control" value="{{ $userType->phone ?? ""}}"
                                                    placeholder="+216 72 000 000" name="phone" onkeypress="return isNumberKey(event)">

                                                    
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
                                                            {{ auth()->user()->city_id == $city->id ? 'selected' : '' }}>
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
                                                            {{ auth()->user()->area_id == $area->id ? 'selected' : '' }}
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


                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Adresse</label>
                                                <input type="text" class="form-control" name="address"
                                                    value="{{ $userType->address ?? ""}}" placeholder="votre adresse">
                                            </div>
                                            @if ($errors->has('address'))
                                                <p class="text-danger">
                                                    {{ $errors->first('address') }}
                                                </p>
                                            @endif
                                        </div>
                                        <input type="hidden" id="type_user" name="type_user"
                                            value="{{ auth()->user()->checkType() }}">

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

            @include('includes.change_password_account')
            <form action="{{ route('updateStore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12">
                    <div class="user-profile-card profile-store">
                        <h4 class="user-profile-card-title">Informations sur le Shop</h4>
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
                                            @if (auth()->user()->store)
                                                {{-- {{ dd('eeeeeeeee') }} --}}
                                                <img src="{{ asset(auth()->user()->store->logo ? 'uploads/store_logos/' . auth()->user()->store->logo : 'assets/img/store/01.jpg') }}"
                                                    alt="Store Logo">
                                            @else
                                                <img src="{{ asset('assets/img/store/01.jpg') }}" alt="Default Store Logo">
                                            @endif

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
                                    <div class="form-group">
                                        <div class="store-banner-preview">
                                            @if (auth()->user()->store)
                                                <img src="{{ asset(auth()->user()->store->logo ? 'uploads/store_banners/' . auth()->user()->store->banner : 'assets/img/store/banner.jpg') }}"
                                                    alt="">
                                            @else
                                                {{-- {{ dd('eeeeee') }} --}}
                                                <img src="{{ asset('assets/img/store/banner.jpg') }}" alt="">
                                            @endif

                                        </div>
                                        <input type="file" name="banner" class="store-file store-file-banner">
                                        @if ($errors->has('banner'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('banner') }}
                                            </div>
                                        @endif
                                        <button type="button" class="theme-btn store-upload-banner mb-4"
                                            onclick="handleImageUpload('.store-upload-banner', '.store-banner-preview img', '.store-file-banner')"><span
                                                class="far fa-upload"></span> Télécharger la bannière</button>
                                    </div>
                                    <div class="form-group">
                                        <label>Nom du boutique</label>
                                        <input type="text" value="{{ auth()->user()->store->store_name ?? '' }}"
                                            class="form-control @error('store_name') is-invalid @enderror" value=""
                                            placeholder="Nom de boutique" name="store_name">
                                    </div>
                                    @if ($errors->has('store_name'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('store_name') }}
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label>Email du contact</label>
                                        <input type="email" name="store_email"
                                            class="form-control @error('store_email') is-invalid @enderror"
                                            value="{{ auth()->user()->store->store_email ?? '' }}"
                                            placeholder="Email de boutique">
                                    </div>
                                    @if ($errors->has('store_email'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('store_email') }}
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>lien Facebook</label>
                                                <input type="text"
                                                    class="form-control @error('fb_link') is-invalid @enderror"
                                                    placeholder="https://www.facebook.com" name="fb_link"
                                                    value="{{ auth()->user()->store->fb_link ?? '' }}">
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
                                                    value="{{ auth()->user()->store->site_link ?? '' }}">

                                                @if ($errors->has('fb_link'))
                                                    <div class="alert alert-danger">
                                                        {{ $errors->first('fb_link') }}
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
            const type = document.getElementById("type_user").value;

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
