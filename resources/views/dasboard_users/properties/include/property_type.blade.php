<div class="col-lg-6">
    <div class="form-group">
        <label>Type de bien
            @include("includes.required")

        </label>
        <select class="select @error('category_id') is-invalid @enderror" name="category_id" required>
            <option value="">Choisir Catégorie</option>

            @foreach ($categories as $item)
                <option value="{{ $item->id }}" {{  
                    isset($property[0]['category_id']) && $property[0]['category_id'] == $item->id ? 'selected' : '' }}
>
                    {{ ucfirst($item->name) }}</option>
            @endforeach
        </select>
    </div>
    @include('message_session.error_field_message', [
        'fieldName' => 'category_id',
    ])
</div>
