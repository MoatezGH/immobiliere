<h6 class=" my-4">Emplacement</h6>

<div class="col-lg-6">
    <div class="form-group">
        <label>Ville</label>
        <select class="select  @error('city_id') is-invalid @enderror" style="display: none;" name="city_id"
            id="citySelect">
            <option value="">Choisir une ville</option>

            @foreach ($cities as $item)
                <option value="{{ $item->id }}"
                    {{ isset($property[0]['city_id']) && $property[0]['city_id'] == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    @include('message_session.error_field_message', [
        'fieldName' => 'city_id',
    ])
</div>
<div class="col-lg-6">
    <div class="form-group" id="area_div">
        <label>Région</label>
        <select class="select @error('area_id') is-invalid @enderror" style="display: none;" name="area_id"
            id="areaSelect">
            <option value="">Choisir une région</option>
            {{-- {{ dd($areas) }} --}}
            @if ($areas)
                {{-- {{ dd('eeeeee') }} --}}
                @foreach ($areas as $item)
                    <option value="{{ $item->id }}"
                        {{ isset($property[0]['area_id']) && $property[0]['area_id'] == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
    @include('message_session.error_field_message', [
        'fieldName' => 'area_id',
    ])
</div>
<div class="col-lg-12">
    <div class="form-group">
        <label>Adresse</label>
        <input type="text" class="form-control" placeholder="Entrer l'adresse" name="address"
            value="{{ isset($property[0]['address']) ? $property[0]['address'] : '' }}">
    </div>
</div>
{{-- <div class="col-lg-6">
    <div class="form-group">
        <label>Code postal</label>
        <input type="text" class="form-control" placeholder="Entrer le code postal" name="code">
    </div>
</div> --}}
