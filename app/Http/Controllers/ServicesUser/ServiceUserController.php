<?php

namespace App\Http\Controllers\ServicesUser;

use Exception;

use App\Models\Area;
use App\Models\City;
use App\Rules\UniqueEmail;
use App\Models\ServiceUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ServiceUserController extends Controller
{
    //

    public function showRegistrationForm()
    {
        return view('auth.register_service');
    }


    public function register(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', new UniqueEmail],
                'phone' => 'nullable|string|max:255',
                'city_id' => 'nullable|integer',
                'country_id' => 'nullable|integer',
                'logo' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'full_name.required' => 'Le nom complet est obligatoire.',
                'email.required' => 'L\'adresse e-mail est obligatoire.',
                'email.email' => 'Veuillez fournir une adresse e-mail valide.',
                'email.unique' => 'Cet e-mail est déjà utilisé.',
                'phone.max' => 'Le numéro de téléphone ne peut pas dépasser 255 caractères.',
                'city_id.integer' => 'L\'identifiant de la ville doit être un nombre entier.',
                'country_id.integer' => 'L\'identifiant du pays doit être un nombre entier.',
                'logo.max' => 'Le logo ne peut pas dépasser 255 caractères.',
                'address.max' => 'L\'adresse ne peut pas dépasser 255 caractères.',
                'password.required' => 'Le mot de passe est obligatoire.',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            ]);

            // dd($validator->fails());

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // dd("test");
            $serviceUser = ServiceUser::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'city_id' => $request->city_id,
                'country_id' => $request->country_id,
                'logo' => $request->logo,
                'address' => $request->address,
                'password' => Hash::make($request->password),
            ]);

            //auth()->guard('service_user')->login($serviceUser);
            // dd(Auth::guard('service_user')->check());
            if (Auth::guard('service_user')->attempt(['email' => $request->email, 'password' => $request->password])) {
                // dd('eee');
                return redirect()->route('show_profile_service');
            } else {
                // dd('eee2');

                Session::flash('error-message', 'Email ou mot de passe invalide');
                return back();
            }
            // dd('eddee');

            // return redirect()->route('service_user_dashboard');
        } catch (\Throwable $e) {
            // dd($e->getMessage());
            // Debug: Check the exception message
            return redirect()->back()->with("error", "Problème de connection." );
        }
    }

    public function dashboard()
    {
        // dd("hello");
        return view('dashboard_service.index');
    }


    public function showProfile()
    {
        try {
            $user = auth()->guard('service_user')->user();
            // dd($user);
            $cities = City::all();
            $areas = Area::all();

            // return "ddd";
            // return view("test", compact("user", "cities", "areas"));
            return view("dashboard_service.profile", compact("user", "cities", "areas"));

        } catch (Exception $e) {
            return redirect()->back()->with("error", "Problème de connection: " );
        }
    }


    public function updateProfile(Request $request)
    {
        try {
            // dd($request->all());

            $user = auth()->guard('service_user')->user();
            //dd($user);

            $user->country_id = $request->city_id ?? $user->country_id;
            $user->city_id = $request->area_id ?? $user->city_id;
            $user->full_name = $request->full_name ?? $user->full_name;
            $user->email = $request->email ?? $user->email;
            $user->phone = $request->phone ?? $user->phone;
            $user->fb_link = $request->fb_link ?? $user->fb_link;
            $user->site_web_link = $request->site_web_link ?? $user->site_web_link ;

            // dd($user);
            if ($request->hasFile('logo')) {
                // dd($request->hasFile('logo'));

                $oldLogoPath=$user->logo;
                $logoName = uniqid('user_service_logo_') . '.' . $request->file('logo')->getClientOriginalExtension();

                $logoPath = public_path('uploads/user_service_logos/' . $logoName);
                // dd($logoPath);

                $this->resizeImage($request->file('logo'), $logoPath, 100, 100);


                if ($oldLogoPath && file_exists(public_path('uploads/user_service_logos/' . $oldLogoPath))) {
                    unlink(public_path('uploads/user_service_logos/' . $oldLogoPath)); // Corrected path
                }
                $user->logo=$logoName;


                
            }

            // dd($user);
            

            $user->update();
            // dd($user);
            
            
            // dd($user);
            return redirect()->back()->with(['success_profile' => 'Profile modifier avec succés']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['profile' => 'échec de la modification du profil' ]);
        }
    }

    public function changePassword(PasswordRequest $request)
    {
        try {
            $user=auth()->guard('service_user')->user();

            // Verify the current password
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->withErrors(['old_password' => 'Ancien mot de passe est incorrect.']);
            }

            // Update the password
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('success_password', 'Mot de passe est bien changer.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_password', 'Probleme de conexion.');
        }
    }

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
