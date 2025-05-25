<link href="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>


{{-- {{ dd($classified->mainPicture->picture_path) }} --}}
<h6 class=" my-4">Importer photo principal</h6>

<div class="col-lg-12">
    <div class="form-group">
        <div class="product-upload-wrapper">
            <div class="product-img-upload main_pic">
                <span onclick="open_main()"><i class="far fa-images"></i> Télécharger image principal de bien</span>
            </div>
            <input type="file" class="product-img-file product-img-file-main" name="photos_main" id="open_main"
                onchange="previewMainPicture(event)">
        </div>
    </div>
    <div class="col-lg-12" id="mainPicturePreview">
        {{-- <img id="mainPicturePreviewImg" src="#" alt="Main Picture Preview"
            style="max-width: 100%; max-height: 300px;"> --}}

        <img id="mainPicturePreviewImg"
            src="{{ asset($classified->mainPicture ? 'uploads/classified/main_picture/' . $classified->mainPicture->picture_path : 'assets/img/product/01.jpg') }}"
            alt="" style="max-width: 100%; max-height: 300px;">
    </div>
</div>


<h6 class=" my-4">Importer des photos</h6>
<small style="
color: red;margin-bottom: 5px !important
">Remarque importante :
    La taille totale des images ne doit pas dépasser 2,5 Méga
    Merci de vérifier avant d'enregistrer votre annonce.</small>
<div class="col-lg-12">
    <div class="form-group">
        <div class="product-upload-wrapper">
            <div class="product-img-upload">
                <span onclick="open_multiple()"><i class="far fa-images"></i> Télécharger images de bien</span>
            </div>
            <input type="file" class="product-img-file" name="photos_multiple[]" multiple
                onchange="previewMultipleImages(event)" id="open_multiple" data-max-files="4" accept="image/*" max="4">
        </div>
    </div>
    <div class="image-preview" id="multipleImagesPreview">
        @foreach ($classified->pictures as $item)
            {{-- {{ dd($item) }} --}}
            <div class="image-preview-item" id="p-{{ $item->id }}">
                <img src="{{ asset('uploads/classified/multi_images/' . $item->picture_path) }}" alt="" >
                <br>
                <div class="d-flex justify-space-between" style="justify-content: space-between;">


                    <button type="button"  data-url="{{ route('delete_image_classified', $item->id) }}"
                        data-id="{{ $item->id }}" class="btn btn-danger btn-sm mt-2 delete-image">
                        <i class="fa fa-trash">
                        </i>
                    </button>

                    {{-- <button type="button" title="image principale"class="btn btn-success btn-sm mt-2"
                        style="font-size: 11px;">

                        Image principale
                    </button> --}}
                </div>
            </div>
        @endforeach
    </div>
</div>



<script>
    // Initialize Bootstrap File Input
    bsCustomFileInput.init();
    // $(".main_pic").click(function() {
    //     console.log('first')
    //     $(".product-img-file-main").click();
    // });

    function open_main(event) {
        // event.previewDefault();
        // console.log('first1')
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

    function open_multiple(event) {
        // event.previewDefault();
        // console.log('first2')
        const button_multiple = document.getElementById('open_multiple');
        button_multiple.click();
    }


    function previewMultipleImages(event) {
        // console.log('ccd22')

        const preview = document.getElementById('multipleImagesPreview');
        // preview.classList.add('d-flex', 'flex-direction-column');
        const maxFiles = 4;

        const files = event.target.files;
        const imageArray = [];
        // console.log(imageArray)
        if (files.length > maxFiles) {
        alert(`Vous ne pouvez télécharger qu'un maximum de ${maxFiles} images`);
        event.target.value = ''; // Clear the input
        return;
    }
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            // console.log(file)

            // Validate file type (optional)
            if (!file.type.match('image.*')) {
                alert('Only image files are allowed.');
                continue; // Skip processing this file
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                const imgWrapper = document.createElement('div');
                imgWrapper.classList.add('image-preview-item');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100%';
                img.style.maxHeight = '300px';
                img.style.marginTop = '10px';
                imgWrapper.appendChild(img);

                const delWrapper = document.createElement('div');
                delWrapper.classList.add('d-flex', 'justify-content-between');

                // Create delete button
                const deleteButton = document.createElement('button');
                deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'mt-2');
                deleteButton.innerHTML = '<i class="fa fa-trash" aria-hidden="true"></i>';
                deleteButton.addEventListener('click', function() {
                    // Remove image preview
                    preview.removeChild(imgWrapper);
                    // Remove image from the array
                    const index = imageArray.indexOf(file);
                    if (index > -1) {
                        imageArray.splice(index, 1);
                    }
                });
                delWrapper.appendChild(deleteButton);
                imgWrapper.appendChild(delWrapper);

                preview.appendChild(imgWrapper);
                preview.style.display = 'block';

                // Add image to the array
                imageArray.push(file);
            };
            imageArray.push(file);

            console.log(imageArray)
            reader.readAsDataURL(file);
        }
    }
</script>
