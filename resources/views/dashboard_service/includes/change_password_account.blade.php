<div class="col-lg-5">
    <div class="user-profile-card">
        <h4 class="user-profile-card-title">Changer le mot de passe </h4>
        <div class="col-lg-12">
            @if (session()->has('success_password'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success_password') }}
                                    </div>
                                @endif
                                @if (session()->has('old_password'))
                                    <div class="alert alert-error">
                                        {{ session()->get('old_password') }}
                                    </div>
                                @endif
                                @if (session()->has('error_password'))
                                    <div class="alert alert-error">
                                        {{ session()->get('error_password') }}
                                    </div>
                                @endif
            <div class="user-profile-form">
                <form action="{{ route('change.user.password.service') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Ancien mot de passe</label>
                        <input type="password" class="form-control" placeholder="********" name="old_password">
                    </div>
                    @if ($errors->has('old_password'))
                        <p class="text-danger">
                            {{ $errors->first('old_password') }}
                        </p>
                    @endif
                    <div class="form-group">
                        <label>Nouveau mot de passe</label>
                        <input type="password" class="form-control" placeholder="********" name="password">
                    </div>
                    @if ($errors->has('password'))
                        <p class="text-danger">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                    {{-- <div class="form-group">
                        <label>Répéter le mot de passe</label>
                        <input type="password" class="form-control" placeholder="********">
                    </div> --}}
                    <button type="submit" class="theme-btn my-3"><span class="far fa-key"></span> Changer le mot de
                        passe</button>
                </form>
            </div>
        </div>
    </div>
</div>
