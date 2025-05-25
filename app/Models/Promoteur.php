<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promoteur extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'user_id',
    //     'first_name',
    //     'last_name',
    //     'last_name',
    // ];
    protected $guarded = [];


    // public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
