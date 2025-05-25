<div class="col-lg-12">
    <div class="form-group">
        <div class="product-upload-wrapper">
            <div class="product-img-upload" onclick="showFileInput(event)">
                <span><i class="far fa-images"></i> Télécharger des images de bien</span>
            </div>
            <input type="file" class="product-img-file" name="photos_main" id="fileInputMain" style="display: none;" accept="image/*"onchange="previewMainImage(event)">
        </div>
    </div>
    <div class="col-lg-12" id="imagePreviewMain" style="display: none;">
        <img id="previewMain" src="#" alt="Image Preview" style="max-width: 100%; max-height: 300px;">
    </div>
</div>

<script>
    function showFileInput(event) {
        event.stopPropagation();
        document.getElementById('fileInputMain').click();
    }

    function previewMainImage(event) {
        var input = event.target;
        console.log(input)
        var preview = document.getElementById('previewMain');
        var imagePreview = document.getElementById('imagePreviewMain');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
