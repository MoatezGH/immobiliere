@extends('layouts.dashboard')
@section('pageTitle')
    Tous les Annonces
@endsection
@section('sectionTitle')
    Tous les Annonces
@endsection
@section('content')
    <div class="user-profile-wrapper">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="user-profile-card profile-ad">
            <h6 class="mb-4">Informations sur l'annonce</h6>

            <div class="user-profile-card-header">
                <div class="">
                    {{-- <div class="flex justify-content-between"> --}}
                    <label for="">Titre:</label>

                    {{-- </div> --}}
                    {{-- <br> --}}
                    <br>
                    {{ $property->title }}


                </div>

                <a href="#" class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="modal"
                    data-bs-target="#statusModal" data-bs-toggle="tooltip" aria-label="detail"
                    data-bs-original-title="detail"><i class="far fa-edit"></i></a>
            </div>
            <div class="col-lg-12">
                <div class="">
                    <label for="">Description:</label>
                    <textarea class="form-control " placeholder="Écrire une description" cols="30" rows="5" name="description"
                        readonly>{{ $property->description }}</textarea>
                </div>

            </div>
            <br>
            <div class="col-lg-12">
                <label for="">Image Principal:</label>
                <div class="row">
                    {{-- @foreach ($property->pictures as $item) --}}
                    <div class="col-md-3">
                        <div class="product-item">
                            <div class="product-img">
                                {{-- <span class="product-status featured">AP1</span> --}}


                                <img src="{{ asset($property->getFirstImageOrDefault() ? 'uploads/promoteur_property/' . $property->getFirstImageOrDefault() : 'assets/img/product/01.jpg') }}"
                                    style="
    
                                                    width:100%;
                                                max-height:170px 
                                            "
                                    alt="test">


                            </div>
                        </div>
                    </div>
                    {{-- @endforeach --}}
                </div>
            </div>
            <br>
            <div class="col-lg-12">
                <label for="">Images:</label>
                <div class="row">
                    @foreach ($property->images as $item)
            @if($item->is_main == 1) @continue @endif;

                        <div class="col-md-3">
                            <div class="product-item">
                                <div class="product-img">
                                    {{-- <span class="product-status featured">AP1</span> --}}


                                    <img src="{{ asset('uploads/promoteur_property/' . $item->title) }} "
                                        style="
    
                                                    width:100%;
                                                max-height:170px 
                                            "
                                        alt="test">


                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-12">
                <label for="">Vedio:</label>
                <div class="row">
                    {{-- @foreach ($property->pictures as $item) --}}
                    <div class="col-md-3">
                        <div class="product-item">
                            <div class="product-img">
                                {{-- <span class="product-status featured">AP1</span> --}}


                                <video id="videoPreview" width="320" height="240" controls
                                    @if (!$property->vedio_path) style="display:none" @endif>
                                    <source id="videoSource"
                                        src="{{ asset($property->vedio_path ? 'uploads/videos/properties/' . $property->vedio_path : '') }}"
                                        type="video/mp4">

                                </video>


                            </div>
                        </div>
                    </div>
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>
        <div class="user-profile-card profile-ad">
            <h6 class="mb-4">Informations sur l'annonceur</h6>

            <div class="user-profile-card-header">
                <div class="">
                    {{-- <div class="flex justify-content-between"> --}}
                    <label for="">Nom & Prenon:</label>

                    {{-- </div> --}}
                    {{-- <br> --}}
                    <br>
                    {{ $property->user->username }}


                </div>

            </div>
            <div class="col-lg-12">
                <div class="">
                    <label for="">Email:</label>
                    <br>
                    {{ $property->user->email }}
                </div>

            </div>
            <br>
            <div class="col-lg-12">
                <label for="">Tel:</label>

                {{ $user_prop->phone }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Changer le statut de la propriété</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your status options here -->
                    <form method="POST"
                        action="{{ route('properties.promoteur.update-status', ['id' => $property->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="statusSelect" class="form-label">Choissi Statut</label>
                            <select class="form-select" id="statusSelect" name="status">
                                <option value="1">Accepté</option>
                                <option value="0">Rejetée</option>
                            </select>
                        </div>
                        <!-- Move the submit button inside the form -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
