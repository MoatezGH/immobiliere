<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Photo;
use App\Models\Operation;
use Illuminate\Support\Carbon;
use App\Models\Property_features;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'properties';





    //for delete user 
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($property) {
            // Delete property images
            // dd();

            if (count($property->pictures) > 0) {
                foreach ($property->pictures as $image) {
                    // Delete image from public folder
                    if (file_exists(public_path('uploads/property_photo/' . $image->alt))) {
                        unlink(public_path('uploads/property_photo/' . $image->alt));
                    }
                    $image->delete();
                }
            }


            if ($property->main_picture) {
                $main_pic = public_path('uploads/main_picture/images/properties/' . $property->main_picture->alt);
                if (file_exists($main_pic)) {
                    unlink($main_pic);
                }
                $property->main_picture->delete();
            }


            //dd($property);

        });
    }
    // public function main_picture($imageId)
    // {

    //     return Image::findOrFail($imageId)->first();
    // }
    public function property_features()
    {
        return $this->hasMany(Property_features::class);
    }

    public function operation()
    {
        return $this->belongsTo(Operation::class); // Assuming a one-to-one relationship
    }
    public function category()
    {
        return $this->belongsTo(Category::class); // Assuming a one-to-one relationship
    }
    public function situation()
    {
        return $this->belongsTo(Situation::class); // Assuming a one-to-one relationship
    }

    public function city()
    {
        return $this->belongsTo(City::class); // Assuming a one-to-one relationship
    }
    public function area()
    {
        return $this->belongsTo(Area::class); // Assuming a one-to-one relationship
    }

    public function main_picture()
    {
        // return Image::find($this->image_id)->first(); // Assuming a one-to-one relationship

        return $this->belongsTo(MainPicture::class, 'image_id', 'id');
    }

    public function pictures()
    {
        return $this->hasMany(Photo::class, 'property_id');
    }

    public function user()
    {
        // return Image::find($this->image_id)->first(); // Assuming a one-to-one relationship

        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    function getCreatedAtAttribute($value)
    {
        // Convert the stored date-time to a Carbon instance
        $createdAt = Carbon::parse($value);

        // Calculate the difference between now and the created at date in days
        $daysAgo = Carbon::now()->diffInDays($createdAt);

        // Format the output based on the number of days
        if ($daysAgo === 0) {
            return 'Aujourd\'hui';
        } elseif ($daysAgo === 1) {
            return 'Hier';
        } else {
            return  date('d M Y', strtotime($createdAt));
        }
    }

    function getRefAttribute($value)
    {
        return strtoupper($value);
    }


    public function incrementViewCount()
    {
        $this->count_views += 1;
        $this->save();
    }

    // public function get_user_name()
    // {
    //     $usertype = $this->user();
    //     dd($usertype);
    // }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }


    public function get_meta_image()
    {
        // $image = $this->main_picture();
        if ($this->main_picture) {

            $image_url = $this->main_picture->alt;
            $path = asset('uploads/main_picture/images/properties/' . $image_url);
            return $path;
        }
        return "";
    }
}
