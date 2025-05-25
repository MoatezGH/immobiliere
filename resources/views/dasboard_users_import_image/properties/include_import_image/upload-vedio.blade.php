<h6 class=" my-4" style="
margin-bottom: 5px !important;
">Importer Vidéo</h6>
<small style="
color: red;margin-bottom: 5px !important
">Remarque importante :
    La durée totale de la vidéo ne doit pas dépasser 2 Minutes 
    Merci de vérifier avant d'enregistrer votre annonce</small>
<div class="col-lg-12">
    <div class="form-group">
        <div class="product-upload-wrapper">
            <div class="product-img-upload main_pic">
                <span onclick="open_vedio()"><i class="far fa-images"></i> Télécharger vidéo de bien</span>
            </div>
            <input type="file" class="product-img-file product-img-file-main" name="video" id="open_vedio"
                accept="video/*" onchange="previewVedio(event)">
        </div>
    </div>
    <div class="col-lg-12" id="mainVedioPreview" style="display: none;">
        {{-- <vedio id="mainVedioPreviewImg" src="#" alt="Main Vedio Preview"
            style="max-width: 100%; max-height: 300px;"> --}}

        {{-- <video width="320" height="240" controls>
            <source id="mainVedioPreviewImg"  src="#" type="video/mp4">

        </video> --}}

        <video id="videoPreview" width="320" height="240" controls style="display:none;">
            <source id="videoSource" src="#" type="video/mp4">

        </video>
    </div>
</div>

<script>
    function open_vedio(event) {
        // event.previewDefault();
        console.log('first1')
        const button = document.getElementById('open_vedio');
        button.click();
    }

    function previewVedio(event) {
        const input = event.target;
        const preview = document.getElementById('videoPreview');
        const divpreview = document.getElementById('mainVedioPreview');

        const source = document.getElementById('videoSource');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                source.src = e.target.result;
                preview.style.display = 'block';
                divpreview.style.display = 'block';

                
                preview.load();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
