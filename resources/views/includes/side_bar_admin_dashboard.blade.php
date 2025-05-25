<div class="user-profile-sidebar">
    @if (!auth()->user()->is_admin)
        <div class="user-profile-sidebar-top">
            @if (session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            <div class="user-profile-img"
                style="background-image:url({{ asset($logo ? 'uploads/user_logos/' . $logo->alt : 'assets/img/account/user.jpg') }});background-size: cover;">

                <img src="{{ asset('assets/img/account/user.jpg') }}" alt="" style="display:none">
                {{-- @endif --}}
                @if (Route::currentRouteNamed('profile_annonceur_immobilier'))
                    <button type="button" class="profile-img-btn"
                        onclick="handleImageUpload('.profile-img-btn', '.user-profile-img img', '.profile-img-file')">
                        <i class="far fa-camera"></i>
                    </button>
                    <input type="file" name="profil-logo" class="profile-img-file">
                @endif

            </div>

            <h5>{{ auth()->user()->username }} @if ($userAccount == 'promoteur')
                    <i class="fa-solid fa-id-badge" title="Promoteur"></i>
                @endif
            </h5>
            <p>{{ auth()->user()->email }}</p>
        </div>
    @endif
    <ul class="user-profile-sidebar-list">
        <li>
            <a class=" {{ Route::currentRouteNamed('dashboard_admin') ? 'active' : '' }}"
                href="{{ route('dashboard_admin') }}"><i class="far fa-gauge-high"></i>
                Tableau de bord admin</a>
        </li>
        <li>
            <a class=" {{ Route::currentRouteNamed('profile_annonceur_immobilier') ? 'active' : '' }}"
                href="{{ route('profile_annonceur_immobilier') }}"><i class="far fa-user"></i>
                Mon compte</a>
        </li>


        <li>
            <a class=" {{ Route::currentRouteNamed('all_admin_company_property') ? 'active' : '' }}"
                href="{{ route('all_admin_company_property') }}"><i class="far fa-layer-group"></i>
                Annonces Entreprises</a>
        </li>

        <li>
            <a class=" {{ Route::currentRouteNamed('all_admin_particulier_property') ? 'active' : '' }}"
                href="{{ route('all_admin_particulier_property') }}"><i class="far fa-layer-group"></i>
                Annonces Particuliers</a>
        </li>

        <li>
            <a class=" {{ Route::currentRouteNamed('all_admin_property_promoteur') ? 'active' : '' }}"
                href="{{ route('all_admin_property_promoteur') }}"><i class="far fa-layer-group"></i>
                Annonces Promoteurs</a>
        </li>
        <li>
            <a class=" {{ Route::currentRouteNamed('admin_classifieds') ? 'active' : '' }}"
                href="{{ route('admin_classifieds') }}"><i class="far fa-layer-group"></i>
                Annonces Débarras</a>
        </li>

        <li>
            <a class=" {{ Route::currentRouteNamed('admin_services') ? 'active' : '' }}"
                href="{{ route('admin_services') }}"><i class="far fa-layer-group"></i>
                Annonces Services</a>
        </li>

        <li>
            <a class=" {{ Route::currentRouteNamed('admin.all_properties_premium') ? 'active' : '' }}"
                href="{{ route('admin.all_properties_premium') }}"><i class="far fa-star"></i>
                Annonces Premium</a>
        </li>
        <li>
            <a class="{{ Route::currentRouteNamed('all_users_admin') ? 'active' : '' }}"
                href="{{ route('all_users_admin') }}"><i class="far fa-users"></i>
                Utilisateurs</a>
        </li>

        <li>
            <a class="{{ Route::currentRouteNamed('all_users_classifieds_admin') ? 'active' : '' }}"
                href="{{ route('all_users_classifieds_admin') }}"><i class="far fa-users"></i>
                Utilisateurs Débarras</a>
        </li>

        <li>
            <a class="{{ Route::currentRouteNamed('all_users_services_admin') ? 'active' : '' }}"
                href="{{ route('all_users_services_admin') }}"><i class="far fa-users"></i>
                Utilisateurs Services</a>
        </li>


        <li>
            <a class="{{ Route::currentRouteNamed('admin.stores') ? 'active' : '' }}"
                href="{{ route('admin.stores') }}"><i class="far fa-store"></i>
                Stores</a>
        </li>


        <li>
            <a class="{{ Route::currentRouteNamed('admin.partenaires.index') ? 'active' : '' }}"
                href="{{ route('admin.partenaires.index') }}"><i class="far fa-image"></i>
                Partenaires</a>
        </li>
        <li>
                <a class="{{ Route::currentRouteNamed('admin.all_sliders') ? 'active' : '' }}"
                    href="{{ route('admin.all_sliders') }}"><i class="far fa-image"></i>
                    Sliders</a>
            </li>


            <li>
                <a class="{{ Route::currentRouteNamed('admin.all_ads') ? 'active' : '' }}"
                    href="{{ route('admin.all_ads') }}"><i class="far fa-ad"></i>
                    Publicités</a>
            </li>

<li>
                <a class="{{ Route::currentRouteNamed('admin.all_service_web') ? 'active' : '' }}"
                    href="{{ route('admin.all_service_web') }}"><i class="far fa-ad"></i>
                    Services</a>
            </li>

        
        <li>


            @csrf <a class="dropdown-item" href="{{ route('signout') }}"><i class="far fa-sign-out"></i>
                Se déconnecter</a>
        </li>
    </ul>
</div>
