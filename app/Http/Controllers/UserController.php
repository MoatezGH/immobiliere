<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\updateProfileRequest;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function updateProfile(updateProfileRequest
    $request, User $user)
    {
        try {
            // dd($request->email);

            $user = auth()->user();

            $user->city_id = $request->city_id;
            $user->area_id = $request->area_id;
            $user->username = $request->username;
            $user->email = $request->email;
            

            $user->save();
            // dd($user);
            if(!$user->isAdmin()){
                $userType = auth()->user()->checkType();
                switch ($userType) {
                    case 'company':
                        $user = auth()->user()->company;
    
                        break;
                    case 'particular':
                        $user = auth()->user()->particular;
    
                        break;
    
                    default:
                        $user = auth()->user()->promoteur;
    
                        break;
                }
    
                if ($userType !== "company") {
                    // dd('1');
                    $fullName = $request->username;
                    $nameParts = explode(" ", $fullName);
                    $firstName = $nameParts[0];
                    $lastName = isset($nameParts[1]) ? $nameParts[1] : " ";
                    $user->first_name = $firstName;
                    $user->last_name = $lastName;
                } else {
                    // dd('2');
    
                    $user->corporate_name = $request->username;
                }
                // dd($request->all());
    
                $user->mobile = $request->mobile;
                $user->phone = $request->phone;
                $user->address = $request->address;
                // dd($user);
    
                $user->save();
            }
            
            // dd($user);
            return redirect()->back()->with(['success_profile' => 'Profile modifier avec succés']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['profile' => 'something  is wrong' ]);
        }
    }

    public function changeLogo(Request $request)
    {
        try {
            $userType = auth()->user()->checkType();
            switch ($userType) {
                case 'company':
                    $user = auth()->user()->company;

                    break;
                case 'particular':
                    $user = auth()->user()->particular;

                    break;

                default:
                    $user = auth()->user()->promoteur;

                    break;
            }
            $oldBannerPath = "";
            // dd($user->logo);
            $logo = Logo::find($user->logo_id);
            if ($logo) {
                $oldBannerPath = $logo->alt;
            }
            if ($request->hasFile('file')) {
                $bannerName = uniqid('user_logo_') . '.' . $request->file('file')->getClientOriginalExtension();

                $bannerPath = public_path('uploads/user_logos/' . $bannerName);
                $this->resizeImage($request->file('file'), $bannerPath, 100, 100);


                if ($oldBannerPath && file_exists(public_path('uploads/user_logos/' . $oldBannerPath))) {
                    unlink(public_path('uploads/user_logos/' . $oldBannerPath)); // Corrected path
                }
                $logo = Logo::create([
                    "alt" => "$bannerName"
                ]);


                $user->update([
                    'logo_id' => $logo->id
                ]);
            }
            session()->flash('message', 'Logo modifier avec succés');
        } catch (\Throwable $th) {
            session()->flash('error', 'Logo modifier avec succés');
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

    public function changePassword(PasswordRequest $request)
    {
        try {
            $user = Auth::user();

            // Verify the current password
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->withErrors(['old_password' => 'Ancien mot de passe est incorrect.']);
            }

            // Update the password
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('success_password', 'mot de passe est bien changer.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Probleme de conexion.');
        }
    }
}
