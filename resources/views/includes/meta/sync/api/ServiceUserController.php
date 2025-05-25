<?php

namespace App\Http\Controllers\api;

use App\Models\Service;



use App\Rules\UniqueEmail;
use App\Models\ServiceUser;
use Illuminate\Support\Str;


use Illuminate\Http\Request;



use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;





class ServiceUserController extends Controller
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
        $user = ServiceUser::where('email', $request->email)->first();

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
            $serviceUser = ServiceUser::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'city_id' => $request->city_id,
                'country_id' => $request->country_id,
                'logo' => $request->logo,
                'address' => $request->address,
                'password' => $request->password,
            ]);

            if (!$serviceUser) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User creation failed:' . $serviceUser,
                ], 500); // 500 Internal Server Error
            } else {
                return response()->json([
                    'status' => 'success',
                    'index' =>$serviceUser->id ,

                    'message' => 'User creation successufly.',
                ], 200);
            }
        } catch (\Throwable $e) {
            // Log the exception for further debugging
            Log::error('Registration failed: ' . $e->getMessage());
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
            
            // Generate slug and unique reference
            $slug = Str::slug($request->title) . '-' . uniqid();
            // Create a new classified ad instance
            $service = new Service([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'service' => $request->service,
                'city_id' => $request->city_id,
                'work_zone' => $request->work_zone,
                'annonceur_type' => $request->annonceur_type,
                'type' => $request->type,
                'description' => $request->description ?? "",
                'user_id' => $request->user_id, // Assuming the user is authenticated
                'ref' => uniqid(), // Generate a unique reference
                'status' => $request->status, // Default status
                'slug' => $slug,
                'paiement_type' => $request->paiement_type
            ]);
            
            // Save the classified ad to the database
            $service->save();
            // Call method to handle main picture upload
            $this->updateMainPicture($request, $service);
            
            // Call method to handle multiple images upload
            $this->updateServiceImages($request, $service);

            // Return JSON response on success
            return response()->json([
                'success' => true,
                'message' => 'Service créée avec succès.',
                'service_id' => $service->id,
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


    //main picture
    private function updateMainPicture($request, $service)
    {
        

        if ($request->hasFile('main_picture')) {

            if ($service->mainPicture) {
                
                $oldPicturePath = public_path('uploads/service/main_picture/' . $service->mainPicture->picture_path);
                
                if (file_exists($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
                $service->mainPicture->delete();
            }
            $image = $request->file('main_picture');
            // return response()->json([
            //     'success' => true,
            //     'message' => 'main 12',
            //     'path' => $image,
            //     'status' => 'success',
            // ], 201);

            $img = Image::make($image);
            $extension = $image->extension();
            $str_random = Str::random(8);
            // $img->resize(729, 398);
            $img->resize(
                520,
                370
            );

            $imgpath = $str_random . time() . "." . $extension;
            
            // Save the resized image
            
            $img->save(public_path('uploads/service/main_picture/' . $imgpath), 100);


            
            // Create a record in the database for the new main picture
            $service->mainPicture()->create([
                'picture_path' =>  $imgpath,
                'service_id' => $service->id,
            ]);

            
            // dd($service);
        }
    }


    //multi image
    private function updateServiceImages($request, $service)
    {

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {

                $img = Image::make($image);
                $extension = $image->extension();
                $str_random = Str::random(8);
                // $img->resize(729, 398);
                $img->resize(520, 370);

                $imgpath = $str_random . time() . "." . $extension;

                // Save the resized image
                $img->save(public_path('uploads/service/multi_images/' . $imgpath), 100);

                // Create a record in the database for the new main picture
                $service->pictures()->create([
                    'picture_path' =>  $imgpath,
                    'service_id' => $service->id,
                ]);
            }
        }
    }
}
