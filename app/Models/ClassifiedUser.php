<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;


class ClassifiedUser extends Authenticatable
{

    
    use Notifiable;

    protected $fillable = [
        'full_name', 'email', 'phone', 'city_id', 'country_id', 'logo', 'address', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
