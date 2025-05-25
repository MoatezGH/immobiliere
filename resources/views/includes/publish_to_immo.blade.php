@if (auth()->guard('classified_user')->check() || auth()->guard('service_user')->check())

<div class="col-6 mt-4">
    <div class="form-check">
        <input class="form-check-input" name="synced" type="checkbox" value="1"
            id="synced" >
        <label style="color:{{env('PRIMARY_COLOR_RED')}}" class="form-check-label" for="synced">
            Publier sur <a  href="{{env('DEUXIEM_SITE_LINK')}}" style="color:{{env('PRIMARY_COLOR_RED')}}">{{env('DEUXIEM_SITE')}}</a> 
        </label>
    </div>
</div>
@elseif(auth()->user()->access_to_publish == 1)
<div class="col-6 mt-4">
    <div class="form-check">
        <input class="form-check-input" name="synced" type="checkbox" value="1"
            id="synced" >
        <label style="color:{{env('PRIMARY_COLOR_RED')}}" class="form-check-label" for="synced">
            Publier sur <a  href="{{env('DEUXIEM_SITE_LINK')}}" style="color:{{env('PRIMARY_COLOR_RED')}}">{{env('DEUXIEM_SITE')}}</a> 
        </label>
    </div>
</div>
@endif