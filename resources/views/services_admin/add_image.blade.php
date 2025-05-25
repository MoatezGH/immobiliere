@extends('layouts.dashboard')
@section('pageTitle')
    Ajouter Un Service
@endsection
@section('sectionTitle')
    Ajouter Un Service
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
    {{-- {{ dd($service) }} --}}
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
            <h4 class="user-profile-card-title">Publier votre annonce</h4>
            <div class="col-lg-12">
                <div class="post-ad-form">
                    <form action="{{ route('admin_add_images_service',$service->id) }}" method="post" enctype="multipart/form-data">

                        @csrf

                        @include('dashboard_service.includes.upload_image')

                        <div class="image-preview" id="imagePreview"></div>

                        <div class="col-lg-12 my-4 align-items-center d-flex">

                            <button style="margin-right: 6px" type="submit" 
                            
                            class="theme-btn mr-2">

                                Publier
                                
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
