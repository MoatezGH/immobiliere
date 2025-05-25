<?php

namespace App\Models;

use App\Models\ServiceUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pictures()
    {
        return $this->hasMany(ServicePicture::class);
    }

    public function mainPicture()
    {
        return $this->hasOne(ServiceMainPicture::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class,"category_id");
    }

    public function user()
    {
        return $this->belongsTo(ServiceUser::class,"user_id");
    }


    public function get_meta_image()
    {
        // dd($this->main_picture());
        // $image = $this->main_picture();
        if ($this->mainPicture) {

            $image_url = $this->mainPicture->picture_path;
            $path = asset('uploads/service/main_picture/' . $image_url);
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
}
