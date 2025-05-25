<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'id',
        'store_name',
        'store_email',
        'logo',
        'banner',
        'user_id',
        'fb_link',
        'site_link',
        'slug',
        'type',
        'nb_view'

    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function userName()
    {
        // $user=$this->user();
        return $this->user->userTypeName();
        // dd($user->userTypeName());
        // return $user;
    }
}
