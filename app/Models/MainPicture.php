<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Intervention\Image\Facades\Image;
class MainPicture extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $guarded = [];

    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'url', 'alt'
    // ];


    // function saveMainPicture($property, $image)
    // {
    //     // Retrieve the property's current main picture
    //     $oldMainPicture = $property->mainPicture;

    //     // Delete the old main picture if it exists
    //     if ($oldMainPicture) {
    //         $oldImagePath = public_path('uploads/main_picture/images/properties/' . $oldMainPicture->alt);
    //         if (file_exists($oldImagePath)) {
    //             unlink($oldImagePath);
    //         }
    //         $oldMainPicture->delete();
    //     }

    //     $img = Image::make($image);
    //     $extension = $image->extension();
    //     $str_random = Str::random(8);
    //     // $img->resize(729, 398);
    //     $img->resize(520, 370);

    //     $imgpath = $str_random . time() . "." . $extension;

    //     // Save the resized image
    //     $img->save(public_path('uploads/main_picture/images/properties/' . $imgpath));

    //     // Create a record in the database for the new main picture
    //     $main_picture = new MainPicture();
    //     $main_picture->alt = $imgpath;
    //     $main_picture->url = $image->getClientOriginalExtension();
    //     $main_picture->save();

    //     // Update the property's image_id with the ID of the new main picture
    //     $property->image_id = $main_picture->id;
    //     $property->save();
    // }


    function saveMainPicture($property, $image)
    {
        // Retrieve the property's current main picture
        $oldMainPicture = $property->mainPicture;

        // Delete the old main picture if it exists
        if ($oldMainPicture) {
            $oldImagePath = public_path('uploads/main_picture/images/properties/' . $oldMainPicture->alt);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $oldMainPicture->delete();
        }

        $img = Image::make($image);
        $extension = $image->extension();
        $str_random = Str::random(8);
        // $img->resize(729, 398);
        $img->resize(520, 370);

        $imgpath = $str_random . time() . "." . $extension;

        // Save the resized image
        $img->save(public_path('uploads/main_picture/images/properties/' . $imgpath));

        // Create a record in the database for the new main picture
        $main_picture = new MainPicture();
        $main_picture->alt = $imgpath;
        $main_picture->url = $image->getClientOriginalExtension();
        $main_picture->save();

        // Update the property's image_id with the ID of the new main picture
        $property->image_id = $main_picture->id;
        $property->save();
    }
}
