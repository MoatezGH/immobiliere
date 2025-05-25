<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Store;
use App\Models\Classified;
use App\Rules\UniqueEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ClassifiedUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreClassifiedRequest;


use Intervention\Image\Facades\Image;





class UserClassifiedController extends Controller
{
    /**
     * Check if a user exists by email.
     */
    public function checkUser(Request $request)
    {
        // Validate the request to ensure 'email' is provided
        // $request->validate([
        //     'email' => 'required|email',
        // ]);
        $validator = Validator::make($request->all(), [
            // 'full_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255'],

        ]);
        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity for validation errors
        }

        // Attempt to find the user by email
        $user = ClassifiedUser::where('email', $request->email)->first();

        // If the user exists, return their ID and other relevant info
        if ($user) {


            return response()->json([
                'index' => $user->id,
                'email' => $user->email,
                'status' => "success",

                'exists' => true,
            ], 200);
        }

        // If the user doesn't exist, return a 404 error
        return response()->json([
            'message' => 'User not found',
            'exists' => false,
            'status' => "success",

        ], 200);
    }


    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     * register user classified
     */
    public function register(Request $request)
    {
        try {
            
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', new UniqueEmail],
                'phone' => 'nullable|string|max:255',
                'city_id' => 'nullable|integer',
                'country_id' => 'nullable|integer',
                'logo' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'password' => 'required|string|min:8',
            ]);

            // Check for validation errors
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ], 422); // 422 Unprocessable Entity for validation errors
            }

            // Create new ClassifiedUser
            $classifiedUser = ClassifiedUser::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'city_id' => $request->city_id,
                'country_id' => $request->country_id,
                'logo' => $request->logo,
                'address' => $request->address,
                'password' => $request->password,
            ]);



            if (!$classifiedUser) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User creation failed:' . $classifiedUser,
                ], 500); // 500 Internal Server Error
            } else {
                return response()->json([
                    'status' => 'success',
                    'index' =>$classifiedUser->id ,

                    'message' => 'User creation successufly.',
                ], 200);
            }
        } catch (\Throwable $e) {
            // Log the exception for further debugging
            \Log::error('Registration failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Server error:' . $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }



    public function store(Request $request)
    {

        // Validate and handle request data
        try {
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Annonce créée avec succès.',
            //     'classified' => $request->main_picture,
            //     'status' => 'success',

            // ], 201);
            // \Log::info($request->all());
            // dd();
            // Generate slug and unique reference
            $slug = Str::slug($request->title) . '-' . uniqid();

            // Create a new classified ad instance
            $classified = new Classified([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'advertis_type' => $request->advertis_type,
                'product_type' => $request->product_type,
                'product_condition' => $request->product_condition,
                'description' => $request->description ?? "",
                'user_id' => $request->user_id, // Assuming the user is authenticated
                'ref' => uniqid(),
                'status' => $request->status, // Default status
                'slug' => $slug,
                'city_id' => $request->city_id,
                'area_id' => $request->area_id
            ]);
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Annonce créée avec succès.',
            //     'classified' => $classified,
                

            // ], 201);
            // Save the classified ad to the database
            $classified->save();


            // Call method to handle main picture upload
            $this->updateMainPicture($request, $classified);

            // Call method to handle multiple images upload
            $this->updateClassifiedImages($request, $classified);

            // Return JSON response on success
            return response()->json([
                'success' => true,
                'message' => 'Annonce créée avec succès.',
                'classified_id' => $classified->id,
                'status' => 'success',

            ], 201); // 201 Created

        } catch (\Throwable $e) {
            // Return JSON error response
            return response()->json([
                'success' => false,
                'message' => 'La création de l\'annonce a échoué.',
                'error' => $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }



    private function updateMainPicture($request, $classified)
    {
        // Check if main photo exists in the request
        if ($request->hasFile('main_picture')) {
            // If there's an existing main picture, delete the old image and record
            if ($classified->mainPicture) {
                $oldPicturePath = public_path('uploads/classified/main_picture/' . $classified->mainPicture->picture_path);
                if (file_exists($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
                $classified->mainPicture->delete();
            }

            // Handle the new main picture
            $image = $request->file('main_picture');

            // Resize and save image
            $img = Image::make($image);
            $extension = $image->extension();
            $str_random = Str::random(8);
            $img->resize(520, 370);

            // Generate new image path
            $imgpath = $str_random . time() . "." . $extension;

            // Save the resized image to disk
            $img->save(public_path('uploads/classified/main_picture/' . $imgpath), 100);

            // Create a new record for the main picture in the database
            $classified->mainPicture()->create([
                'picture_path' => $imgpath,
                'classified_id' => $classified->id,
            ]);
        }
    }



    private function updateClassifiedImages($request, $classified)
    {
        // Check if multiple images are provided
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Resize and handle each image
                $img = Image::make($image);
                $extension = $image->extension();
                $str_random = Str::random(8);
                $img->resize(520, 370);

                // Generate new image path
                $imgpath = $str_random . time() . "." . $extension;

                // Save the resized image to disk
                $img->save(public_path('uploads/classified/multi_images/' . $imgpath), 100);

                // Save image information in the database
                $classified->pictures()->create([
                    'picture_path' => $imgpath,
                    'classified_id' => $classified->id,
                ]);
            }
        }
    }
}
