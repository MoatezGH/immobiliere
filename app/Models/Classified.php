<?php

namespace App\Models;

use App\Models\ClassifiedUser;
use App\Models\ClassifiedTypes;
use App\Models\ClassifiedCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classified extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'category_id', 'product_condition',
        'product_type', 'advertis_type', 'price', 'user_id', 'ref', 'status',"slug","count_views","city_id","area_id","synced"
    ];

    public function pictures()
    {
        return $this->hasMany(ClassifiedPicture::class);
    }

    public function mainPicture()
    {
        return $this->hasOne(ClassifiedMainPicture::class);
    }

    public function category()
    {
        return $this->belongsTo(ClassifiedCategory::class,"category_id");
    }

    public function user()
    {
        return $this->belongsTo(ClassifiedUser::class,"user_id");
    }

    public function type()
    {
        return $this->belongsTo(ClassifiedTypes::class,"product_type");
    }


    public function get_meta_image()
    {
        // dd($this->main_picture());
        // $image = $this->main_picture();
        if ($this->mainPicture) {

            $image_url = $this->mainPicture->picture_path;
            $path = asset('uploads/classified/main_picture/' . $image_url);
            return $path;
        }
        return "";
    }

    public function incrementViewCount()
    {
        $this->count_views += 1;
        $this->save();
    }

    public function city()
    {
        return $this->belongsTo(City::class); // Assuming a one-to-one relationship
    }
    public function area()
    {
        return $this->belongsTo(Area::class); // Assuming a one-to-one relationship
    }
}
