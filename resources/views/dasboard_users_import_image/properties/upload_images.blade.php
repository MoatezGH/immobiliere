@extends('layouts.dashboard')
@section('pageTitle')
    Ajouter Images & Vedios
@endsection
@section('sectionTitle')
    Ajouter Images & Vedios
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
{{-- {{ dd(phpinfo()) }} --}}
    {{-- {{ dd($property) }} --}}
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
            <h4 class="user-profile-card-title">Ajouter Images & Vedios</h4>
            <form action="{{ route('properties.uploadfile',$property) }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="col-lg-12">
                <div class="post-ad-form">
                    <div class="row align-items-center">
                        @include('dasboard_users.properties.include.upload_image')

                        {{-- @include('dasboard_users.properties.include.upload-vedio') --}}

                        <div class="image-preview" id="imagePreview"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 my-4">
                <button type="submit" class="theme-btn">Publier</button>
            </div>
        </div>
    @endsection
