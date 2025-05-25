<?php

namespace App\Models;

use App\Models\Logo;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'corporate_name',
        'category',
        'logo_id',
        'mobile',
        'phone'


        // 'category'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function logo()
    // {
        
    //     $logo = $this->logo_id;
    //     if($logo) return $logo;
    //     return "0";
    // }
}
