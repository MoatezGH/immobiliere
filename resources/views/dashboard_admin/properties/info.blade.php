@extends('layouts.dashboard')
@section('pageTitle')
    Detail 
@endsection
@section('sectionTitle')
    Detail
@endsection
@section('content')
    {{-- {{ dd($user_prop) }} --}}
    {{-- {{dd("enter info")}} --}}

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
            <br>
            <div class="d-flex justify-content-between">
                @if ($property->state == 'valid')
                    <button class="btn btn-sm btn-success">Validé</button>
                @elseif ($property->state == 'waiting')
                    {{-- <p>test</p> --}}

                    <button class="btn btn-sm btn-warning">En attente</button>
                @else
                    <button class="btn btn-sm btn-danger">Invalidé</button>
                @endif
                <a href="#" class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="modal"
                    data-bs-target="#statusModal" data-bs-toggle="tooltip" aria-label="detail"
                    data-bs-original-title="detail" style="
    background-color: darkgrey;
    color: black;
"><i
                        class="far fa-edit"></i></a>
            </div>


            <br>
            {{-- <div class="user-profile-card-header"> --}}
            {{-- <div class=""> --}}

            {{-- <div class="flex justify-content-between"> --}}

            <div class="col-lg-12">


                <div class="form-group">
                    <label>Titre</label>
                    <textarea class="form-control " placeholder="Écrire une description" cols="30" rows="5" name="description"
                        readonly>{{ $property->title }}</textarea>
                </div>
                {{-- {{ $property->title }} --}}
            </div>
            <br>
            {{-- </div> --}}
            {{-- <br> --}}



            {{-- </div> --}}


            {{-- </div> --}}
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control " placeholder="Écrire une description" cols="30" rows="5" name="description"
                        readonly>{{ $property->description }}</textarea>
                </div>

            </div>
            {{-- <div class="col-lg-12">
                <div class="">
                    <label for="">Description:</label>
                    <br>
                    {{ $property->description }}
                </div>

            </div> --}}
            <br>
            <div class="col-lg-12">
                <label for="">Image Principal:</label>
                <div class="row">
                    {{-- @foreach ($property->pictures as $item) --}}
                    <div class="col-md-3">
                        <div class="product-item">
                            <div class="product-img">
                                {{-- <span class="product-status featured">AP1</span> --}}


                                <img src="{{ asset($property->main_picture ? 'uploads/main_picture/images/properties/' . $property->main_picture->alt : 'assets/img/product/01.jpg') }} "
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
                    @foreach ($property->pictures as $item)
                        <div class="col-md-3">
                            <div class="product-item">
                                <div class="product-img">
                                    {{-- <span class="product-status featured">AP1</span> --}}


                                    <img src="{{ asset('uploads/property_photo/' . $item->alt) }} "
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
                    @if($property->user->isCompany())
                    {{ $user_prop->corporate_name ?? '' }}
                    @else
                    {{ $user_prop->first_name ?? '' }}  {{ $user_prop->last_name ?? '' }}

                    @endif


                </div>

            </div>
            <div class="col-lg-12 user-profile-card-header">
                <div class="">
                    <label for="">Email:</label>
                    <br>
                    {{ $property->user->email }}
                </div>

            </div>
            {{-- <br> --}}
            <div class="col-lg-12 user-profile-card-header">
                <div class="">

                    <label for="">Tel:</label>
                    <br>
                    {{ $user_prop->phone ?? '' }}
                </div>

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
                    <form method="POST" action="{{ route('properties.update-status', ['id' => $property->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="statusSelect" class="form-label">Choissi Statut</label>
                            <select class="form-select" id="statusSelect" name="status">
                                <option value="valid">Accepté</option>
                                <option value="invalid">Rejetée</option>
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
