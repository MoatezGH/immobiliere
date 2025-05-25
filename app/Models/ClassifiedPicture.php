<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassifiedPicture extends Model
{
    use HasFactory;

    protected $fillable = ['classified_id', 'picture_path'];

    public function classified()
    {
        return $this->belongsTo(Classified::class);
    }
}
