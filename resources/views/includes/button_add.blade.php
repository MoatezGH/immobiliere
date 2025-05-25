@if (!Auth::check() && !auth()->guard('classified_user')->check() && !auth()->guard('service_user')->check())

<a href="{{route('login')}}" class="theme-btn mt-2"><span class="far fa-plus-circle"></span></a>



@elseif (auth()->guard("service_user")->check())
<a href="{{ route('service_show_add') }}" class="theme-btn mt-2"><span class="far fa-plus-circle"></span></a>

@elseif (auth()->guard('classified_user')->check())
<a href="{{ route('show_add') }}" class="theme-btn mt-2"><span class="far fa-plus-circle"></span></a>

@else

@if (auth()->user()->is_admin)


                    <li class="nav-item" id="log_out">
                        <a class="nav-link" href="{{ route('all_admin_property_promoteur') }}"><i class="far fa-user"></i>
                            Espace Admin</a>
                    </li>
                    <a href="{{ route('get_add_property') }}" class="theme-btn mt-2"><span class="far fa-plus-circle"></span></a>
                    @else
                    <li class="nav-item" id="log_out">
                        <a class="nav-link" href="{{ route('profile_annonceur_immobilier') }}"><i class="far fa-user"></i>
                            Dashboard</a>
                    </li>
                    <a href="{{ route('get_add_property') }}" class="theme-btn mt-2"><span class="far fa-plus-circle"></span></a>
                    @endif


@endif