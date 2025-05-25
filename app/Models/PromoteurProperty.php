<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Models\Property_features;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoteurProperty extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'promoteur_properties';

    public function property_features()
    {
        return $this->hasMany(Property_features::class,"property_id","id");
    }

    //for delete user 
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($property) {
            // Delete property images
            foreach ($property->images as $picture) {
                $picturePath = public_path('uploads/promoteur_property/'.$picture->title);
                if (file_exists($picturePath)) {
                    unlink($picturePath);
                }
                $picture->delete(); // Delete picture record from database
            }


        });
    }

    public function images()
    {
        return $this->hasMany(PromoteurPropertyImage::class, 'property_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class); // Assuming a one-to-one relationship
    }


    public function operation()
    {
        return $this->belongsTo(Operation::class); // Assuming a one-to-one relationship
    }


    public function city()
    {
        return $this->belongsTo(City::class); // Assuming a one-to-one relationship
    }


    public function area()
    {
        return $this->belongsTo(Area::class); // Assuming a one-to-one relationship
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
            return date('d M Y', strtotime($createdAt));
        }
    }

    function getRefAttribute($value)
    {
        return strtoupper($value);
    }

    public function getFirstImageOrDefault()
    {
        // Check if the property has any images
        if ($this->images()->count() > 0) {
            // Retrieve the main image, if available
            $mainImage = $this->images()->where('is_main', 1)->first();
            // dd($this->images()->first());
            if (!$mainImage) {
                $firstImage = $this->images()->first();
                return $firstImage ? $firstImage->title : null;
            }

            return $mainImage->title;
        }

        // If no images are available, return null or handle as needed
        return null;
    }

    public function user()
    {
        // return Image::find($this->image_id)->first(); // Assuming a one-to-one relationship

        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function incrementViewCount()
    {
        $this->count_views += 1;
        $this->save();
    }

    public function get_meta_image(){
        $image = $this->getFirstImageOrDefault(); // Ensure this method returns the correct image filename
        $path = asset('uploads/promoteur_property/' . $image);
        return $path;
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
}
