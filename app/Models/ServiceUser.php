<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

class ServiceUser extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'full_name', 'email', 'phone', 'city_id', 'country_id', 'logo', 'address', 'password','last_login'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
