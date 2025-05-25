<div class="dropdown">
    <div data-bs-toggle="dropdown" aria-expanded="false">

        <img src="
        {{ asset('assets/img/account/user.jpg') }} "
            alt="user">
    </div>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="{{ route('show_profile_classified') }}"><i class="far fa-user"></i>
                Mon Compte</a>
        </li>
        <li>
            <a class="dropdown-item"href="{{ route('index_classified') }}"><i class="far fa-layer-group"></i>
                Mes Annonces</a>
        </li>
        <li>
            @csrf <a class="dropdown-item" href="{{ route('signout') }}"><i
                    class="far fa-sign-out"></i>
                Log Out</a>


        </li>
    </ul>
</div>