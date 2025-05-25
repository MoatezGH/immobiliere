@extends('layouts.dashboard_classified')
@section('pageTitle')
    Modifier images
@endsection
@section('sectionTitle')
Modifier images
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
    {{-- {{ dd($classified) }} --}}
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
            <h4 class="user-profile-card-title">Publier gratuitement votre annonce</h4>
            <div class="col-lg-12">
                <div class="post-ad-form">
                    <form action="{{ route('add_images_classified',$classified->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('dashboard_classified.includes.upload_image')

                        <div class="image-preview" id="imagePreview"></div>
                        <div class="col-lg-12 my-4 align-items-center d-flex">
                            <button style="margin-right: 6px" type="submit" class="theme-btn mr-2">Modifier </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
