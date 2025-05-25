<div class="user-profile-sidebar">
    <div class="user-profile-sidebar-top">
        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <div class="user-profile-img" {{-- style="background-image:url({{ asset($logo ? 'uploads/user_logos/' . $logo->alt : 'assets/img/account/user.jpg') }});background-size: cover;" --}}
            style="background-image:url({{ asset(auth()->user()->getLogo() ? 'uploads/store_logos/' .  auth()->user()->getLogo()  : 'assets/img/account/user.jpg') }});background-size: cover;"
            {{-- <img src="
                                        {{ asset($user_logo ? 'uploads/store_logos/' . $user_logo : 'assets/img/account/user.jpg') }} "
                                                alt=""> --}}>
            {{-- {{ dd($logo) }} --}}
            {{-- {{ dd('eeeeeeeee') }} --}}
            {{-- <img src="{{ asset($logo ? 'uploads/user_logos/' . $logo->alt : 'assets/img/account/user.jpg') }}"
                    alt="Store Logo"> --}}
            {{-- @else --}}
            {{-- <img src="{{ asset('assets/img/account/user.jpg') }}" alt="" style="display:none"> --}}
            {{-- @endif --}}
            {{-- @if (Route::currentRouteNamed('profile_annonceur_immobilier'))
                <button type="button" class="profile-img-btn"
                    onclick="handleImageUpload('.profile-img-btn', '.user-profile-img img', '.profile-img-file')">
                    <i class="far fa-camera"></i>
                </button>
                <input type="file" name="profil-logo" class="profile-img-file">
            @endif --}}

        </div>

        <h5>{{ auth()->user()->username }} @if (auth()->user()->checkType() == 'promoteur')
                <i class="fa-solid fa-id-badge" title="Promoteur"></i>
            @endif
        </h5>
        <p>{{ substr(auth()->user()->email, 0, 38) }}</p>
    </div>
    <ul class="user-profile-sidebar-list">
        <li>
            <a class=" {{ Route::currentRouteNamed('dashboard_annonceur_immobilier') ? 'active' : '' }}"
                href="{{ route('dashboard_annonceur_immobilier') }}"><i class="far fa-gauge-high"></i>
                Tableau de bord</a>
        </li>
        <li>
            <a class=" {{ Route::currentRouteNamed('profile_annonceur_immobilier') ? 'active' : '' }}"
                href="{{ route('profile_annonceur_immobilier') }}"><i class="far fa-user"></i>
                Mon compte</a>
        </li>

        @can('isAgent')
            <li>
                <a class=" {{ Route::currentRouteNamed('all_user_property') ? 'active' : '' }}"
                    href="{{ route('all_user_property') }}"><i class="far fa-layer-group"></i>
                    Mes annonces</a>
            </li>
            <li>
                <a class="{{ Route::currentRouteNamed('get_add_property') ? 'active' : '' }}"
                    href="{{ route('get_add_property') }}"><i class="far fa-plus-circle"></i>
                    Publier des annonces</a>
            </li>
        @endcan
        @can('isPromoteur')
            <li>
                <a class=" {{ Route::currentRouteNamed('all_promoteur_property') ? 'active' : '' }}"
                    href="{{ route('all_promoteur_property') }}"><i class="far fa-layer-group"></i>
                    Mes annonces</a>
            </li>
            <li>
                <a class="{{ Route::currentRouteNamed('get_add_property') ? 'active' : '' }}"
                    href="{{ route('get_add_property') }}"><i class="far fa-plus-circle"></i>
                    Publier des annonces</a>
            </li>
            {{--  --}}
        @endcan

        {{-- <li>
            <a href="#"><i class="far fa-folder-gear"></i>
                Paramètres des annonces</a>
        </li> --}}
        {{-- <li>
            <a href="profile-favorite.html"><i class="far fa-heart"></i> My
                Favorites</a>
        </li>
        <li>
            <a href="profile-message.html"><i class="far fa-envelope"></i>
                Messages
                <span class="badge bg-danger">02</span></a>
        </li>
        <li>
            <a href="profile-payment.html"><i class="far fa-wallet"></i>
                Payments</a>
        </li>
        <li>
            <a href="profile-setting.html"><i class="far fa-gear"></i>
                Settings</a>
        </li> --}}
        <li><a class="{{ Route::currentRouteNamed('user_favories') ? 'active' : '' }}" href="{{ route('user_favories') }}"><i class="far fa-heart"></i> Mes favoris</a></li>
        <li>


            @csrf <a class="dropdown-item" href="{{ route('signout') }}"><i class="far fa-sign-out"></i>
                Se déconnecter</a>
        </li>
    </ul>
</div>
