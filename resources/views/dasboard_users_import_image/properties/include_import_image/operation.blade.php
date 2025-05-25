<div class="col-lg-6">
    <div class="form-group">
        <label>Opération</label>
        <select class="select @error('area_id') is-invalid @enderror" style="display: none;" name="operation_id">
            <option value="">Choisir une opération</option>

            @foreach ($operations as $item)
                <option value="{{ $item->id }}"
                    {{ isset($property[0]['operation_id']) && $property[0]['operation_id'] == $item->id ? 'selected' : '' }}>
                    {{ ucfirst($item->title) }}</option>
            @endforeach
        </select>
    </div>
    @include('message_session.error_field_message', [
        'fieldName' => 'operation_id',
    ])
</div>
