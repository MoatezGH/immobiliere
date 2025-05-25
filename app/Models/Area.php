<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'id',
        'city_id'

    ];
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
