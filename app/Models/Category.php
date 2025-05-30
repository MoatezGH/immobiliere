<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function getTitleAttribute($value)
    {
        return strtoupper($value); // Convert to uppercase before returning
    }
}
