<div class="user-profile-sidebar">
    <div class="user-profile-sidebar-top">
        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <div class="user-profile-img" style="background-image:url({{ asset('assets/img/account/user.jpg') }});background-size: cover;"
            {{-- style="background-image:url({{ asset(auth()->user()->getLogo() ? 'uploads/store_logos/' .  auth()->user()->getLogo()  : 'assets/img/account/user.jpg') }});background-size: cover;" --}}
            >
            
            

        </div>

        <h5>{{ auth()->guard('service_user')->user()->full_name }} 
        </h5>
        <p>{{ substr(auth()->guard('service_user')->user()->email, 0, 38) }}</p>
    </div>
    <ul class="user-profile-sidebar-list">
        <li>
            <a class=" {{ Route::currentRouteNamed('dashboard_annonceur_immobilier') ? 'active' : '' }}"
                href="{{ route('dashboard_annonceur_immobilier') }}"><i class="far fa-gauge-high"></i>
                Tableau de bord</a>
        </li>
        <li>
            <a class=" {{ Route::currentRouteNamed('service_user_profil') ? 'active' : '' }}"
                href="{{ route('service_user_profil') }}"><i class="far fa-user"></i>
                Mon compte</a>
        </li>

        
        <li><a class="{{ Route::currentRouteNamed('user_favories') ? 'active' : '' }}" href="{{ route('user_favories') }}"><i class="far fa-heart"></i> Mes favoris</a></li>
        <li>


            @csrf <a class="dropdown-item" href="{{ route('signout') }}"><i class="far fa-sign-out"></i>
                Se déconnecter</a>
        </li>
    </ul>
</div>
