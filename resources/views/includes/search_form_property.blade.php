<div class="row">
    <h5 class="mb-4">Rechercher des annonces</h5>
    <div class="col-lg-12">
        <div class="form-group">
            <div class="form-group-icon">
                <input type="text" class="form-control" placeholder="Cherche..." name="reference" value="{{ request()->reference }}">
                <i class="far fa-search"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <div class="form-group-icon">
                <select class="select" name="city_id" id="citySelect">
                    <option value="">Ville</option>
                    @foreach ($cities as $item)
                    <option value="{{ $item->slug }}" {{ $item->slug == $city_name ? 'selected' : '' }}  data-id=" {{ $item->id }}">
                        {{ $item->name }}
                    </option>
                    @endforeach

                </select>

                <i class="far fa-location-dot"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group" id="area_div">
            <div class="form-group-icon">
                <select class="select" name="area_id" id="areaSelect">
                    <option value="">Région</option>
                    @foreach ($areas as $item)
                    <option value="{{ $item->slug }}" {{ $item->slug == $area_name ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                    @endforeach

                </select>

                <i class="far fa-location-dot"></i>
            </div>
        </div>
    </div>
    <h5 class="mt-2 mb-3">Catégorie</h5>
    <div class="col-12 mb-1">
        <div class="sidebar-category">
            
            <div class="form-group-icon">
                <select class="select" name="category_id" >
                    <option value="" disabled selected>Catégorie</option>
                    @foreach ($categories as $item)
                    <option value="{{ $item->slug }}" {{ $item->slug== $category_name  ? 'selected' : '' }}>
                        {{ ucfirst($item->name) }}
                    </option>
                    @endforeach

                </select>
                <i class="far fa-bars-sort"></i>
            </div>
            <small class="text-danger" id="category_error" style="display:none">Veuillez sélectionner une catégorie</small>

        </div>
    </div>

    <h5 class="mt-2 mb-3">Opération</h5>
    @foreach ($operations as $item)
    <div class="col-12 mb-2">
        <div class="form-check">
            <input class="form-check-input" name="operation_id" type="radio" value="{{ $item->name }}" {{ $item->name == $operation_name ? 'checked' : '' }}  required>
            <label class="form-check-label" for="type2">
                {{ ucfirst($item->name) }}
            </label>
        </div>

    </div>
    @endforeach

    <h5 class="mt-2 mb-3">Prix</h5>
    {{-- <label for=""></label> --}}
    <!-- <div class="form-group">

        <div class="form-group-icon"> -->
            <input name="min_price" class="form-control mb-2" placeholder="Minimum" type="number" value="{{ request()->min_price ?? '' }}" style="
                            padding-left: 16px;
                        ">
            {{-- <i class="far fa-location-dot"></i> --}}
        <!-- </div>
    </div> -->


    <input name="max_price" class="form-control" placeholder="Maximum" type="number" style="
                    padding-left: 16px;
                " value="{{ request()->max_price ?? '' }}">




<div class="col-lg-12 mt-3">
    <!-- <button type="button" class="theme-btn" ><span class="far fa-search" ></span>Chercher</button> -->
    <button type="submit" class="theme-btn">
        <span class="far fa-search"></span> Chercher
    </button>
</div>
</div>