<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use Intervention\Image\Laravel\Facades\Image;

class StoreController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }



    public function updateStore(UserStoreRequest $request)
    {

        // dd($request->all());
        try {
            //$store = Store::findOrFail(auth()->user()->store->id); // Find the store by ID
            $user = auth()->user();
            $userType = $user->checkType();
            // dd($userType);
            $store = Store::where('user_id', $user->id)->first();
            // dd($store);

            if (!$store) {
                $store = new Store;
                $store->user_id = $user->id;  // Associate with the current user
            }
            $store->store_name = $request->store_name;
            $store->store_email = $request->store_email;
            $store->fb_link = $request->fb_link;
            $store->site_link = $request->site_web_link;
            $store->type = $userType;
            $store->slug = $request->store_name . '_' . now()->format('YmdHis');



            // dd($store);

            // dd('go');
            $oldLogoPath = $store->logo; // Store the path of the old logo (if any)
            $oldBannerPath = $store->banner; // Store the path of the old banner (if any)

            // Handle Logo Upload (if present)
            if ($request->hasFile('logo')) {
                $logoName = uniqid('store_logo_') . '.' . $request->file('logo')->getClientOriginalExtension();
                $logoPath = public_path('uploads/store_logos/' . $logoName); // Full path for storage

                // Resize and store the logo
                $this->resizeImage($request->file('logo'), $logoPath, 500, 500);

                $store->logo = $logoName; // Update store's logo attribute

                // Delete old logo if it exists
                if ($oldLogoPath && file_exists(public_path('uploads/store_logos/' . $oldLogoPath))) {
                    unlink(public_path('uploads/store_logos/' . $oldLogoPath)); // Delete old logo file
                }
            }

            // Handle Banner Upload (if present)
            if ($request->hasFile('banner')) {
                $bannerName = uniqid('store_banner_') . '.' . $request->file('banner')->getClientOriginalExtension();
                $bannerPath = public_path('uploads/store_banners/' . $bannerName); // Full path for storage (typo corrected)

                // Resize and store the banner
                $this->resizeImage($request->file('banner'), $bannerPath, 1920, 550);
                $store->banner = $bannerName; // Update store's banner attribute

                // Delete old banner if it exists
                if ($oldBannerPath && file_exists(public_path('uploads/store_banners/' . $oldBannerPath))) {
                    unlink(public_path('uploads/store_banners/' . $oldBannerPath)); // Corrected path
                }
            }
// dd($store);
            $store->save(); // Save the updated store data

            // dd($save);

            // return response()->json([
            //     'message' => 'Store updated successfully!',
            // ], 200); // Return success response

            return redirect()->back()->with(['success_store' => 'Boutique modifier avec succés']);
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    // Function to resize image (assuming GD library is installed)
    private function resizeImage($image, $path, $width, $height)
    {
        $extension = strtolower($image->getClientOriginalExtension());

        if (!in_array($extension, ['gif', 'png', 'jpg', 'jpeg'])) {
            throw new Exception('Unsupported image format'); // Handle unsupported formats
        }

        $image = imagecreatefromstring($image->getContent());

        if (!$image) {
            throw new Exception('Failed to create image object'); // Handle image creation errors
        }

        $thumb = imagecreatetruecolor($width, $height);

        $sourceWidth = imagesx($image);
        $sourceHeight = imagesy($image);

        // Maintain aspect ratio (optional)
        $aspectRatio = min($width / $sourceWidth, $height / $sourceHeight);
        $newWidth = $sourceWidth * $aspectRatio;
        $newHeight = $sourceHeight * $aspectRatio;

        $offsetX = ($width - $newWidth) / 2;
        $offsetY = ($height - $newHeight) / 2;

        imagecopyresampled($thumb, $image, $offsetX, $offsetY, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);

        switch ($extension) {
            case 'gif':
                imagegif($thumb, $path);
                break;
            case 'png':
                imagepng($thumb, $path);
                break;

            default:
                imagejpeg($thumb, $path, 80); // Adjust quality as needed
                break;
        }

        imagedestroy($image);
        imagedestroy($thumb);
    }

    
}
