<style>
    .search-form .nice-select {
        height: 45px;
        display: flex;
        align-items: center;
    }
</style>

<div class="user-profile-card-header-right">
    {{-- <div class="user-profile-search search-form">
        <div class="form-group ">
            <select class=" select" aria-label="Default select example" name="user_id">
                <option value="">Choisir Utilisateur</option>
                <option value="">Tous
                </option>
                @foreach ($users as $item)
                    <option value="{{ $item->id }}" {{ request()->user_id == $item->id ? 'selected' : '' }}>
                        {{ $item->userTypeName() }}
                    </option>
                @endforeach
            </select>
            <i class="far fa-user"></i>



        </div>


    </div> --}}

    <div class="user-profile-search search-form ">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Cherche..." name="user_name"
                                    value="">
                                <i class="far fa-search"></i>



                            </div>


                        </div>
    <div class="user-profile-search search-form">
        <div class="form-group ">
            <select class=" select" aria-label="Default select example" name="category_id">
                <option value="">Choisir Categorie</option>
                <option value="">Tous
                </option>
                @foreach ($categories as $item)
                    <option value="{{ $item->id }}" {{ request()->category_id == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            <i class="far fa-bars-sort"></i>




        </div>


    </div>
    <div class="user-profile-search search-form ">
        <div class="form-group">
            <select class=" select" aria-label="Default select example" name="status">
                <option value="">Choisir Statut</option>
                <option value="valid" {{ request()->status == 'valid' ? 'selected' : '' }}>Acitve</option>
                {{-- <option value="invalid" {{ request()->status == 'invalid' ? 'selected' : '' }}>Inactive</option> --}}

                <option value="waiting" {{ request()->status == 'waiting' ? 'selected' : '' }}>En Attente</option>



            </select>


            <i class="far fa-bars-sort"></i>

        </div>


    </div>
    <div class="user-profile-search search-form">
        <div class="form-group">
            <input type="date" value="{{ isset(request()->created_at) ? request()->created_at : '' }}"
                class="form-control" name="created_at">
            <i class="far fa-calendar"></i>

        </div>


    </div>

    <button type="submit" class="theme-btn"><span class="far fa-search"></span></button>
</div>
