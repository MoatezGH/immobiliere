<div class="col-6 mt-4">
    <div class="form-check">
        <input class="form-check-input" name="synced" type="checkbox" value="1"
            id="synced" {{  $property[0]['synced'] == 1 ? 'checked' : '' }}>
        <label style="color:#fc3131" class="form-check-label" for="synced">
            Publier sur <a href="{{env(DEUXIEM_SITE_link)}}">{{env(DEUXIEM_SITE)}}</a> 
        </label>
    </div>
</div>