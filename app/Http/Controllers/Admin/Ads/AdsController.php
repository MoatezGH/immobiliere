<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Models\Ad;
use App\Models\Statistique;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class AdsController extends Controller
{
    public function __construct(){
        try {
            $this->middleware(function($request,$next){
                if(auth()->check() && auth()->user()->is_admin==1){
                    return $next($request);
                }
                return redirect('/');

            });
        } catch (\Throwable $e) {
            redirect()->back();
        }
    }
    public function index()
    {

        try {
            $user = auth()->user();
        if (!$user->isAdmin()) {
            return redirect()->back();
        }
        $ads = Ad::orderBy("created_at", "desc")->paginate(8);
        return view("dashboard_admin.ads.index", compact("ads"));
        } catch (\Throwable $e) {
            return redirect()->back();

        }
        
    }

    public function add()
    {
        try {
            $user = auth()->user();
        if (!$user->isAdmin()) {
            return redirect()->back();
        }

        return view("dashboard_admin.ads.add");
        } catch (\Throwable $e) {
            return redirect()->back();

        }
        
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $user = auth()->user();

            if (!$user->isAdmin()) {
                return redirect()->back();
            }
            $ad = new Ad();

            $ad->description = $request->title;
            $ad->url = $request->lien;
            $ad->active = isset($request->publish_now) ? $request->publish_now : 0;
            // dd($ad);
            if ($request->hasFile('photos_main')) {
                $image = $request->photos_main;

                $img = Image::make($image);
                $extension = $image->extension();
                $str_random = Str::random(8);
                // $img->resize(729, 398);
                $img->resize(
                    1920,
                    1280
                );

                $imgpath = $str_random . time() . "." . $extension;

                // Save the resized image
                $img->save(public_path('uploads/ads/' . $imgpath), 100);


                $ad->alt = $imgpath;


                // Update the property's image_id with the ID of the new main picture

                // $property->save();
            }
        // dd($ad);
            $ad->save();

            return redirect()->back()->with('success', 'pub crée avec succés.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['adError' => 'Ad not saved ']);
        }
    }

    public function edit($id)
    {
        try {
            $user = auth()->user();
            if (!$user->isAdmin()) {
                return redirect()->back();
            }
            $ad = Ad::find($id);
            return view("dashboard_admin.ads.edit", compact('ad'));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = auth()->user();

            if (!$user->isAdmin()) {
                return redirect()->back();
            }

            $ad = Ad::findOrFail($id);

            $ad->description = $request->title;
            $ad->url = $request->lien;
            $ad->active = isset($request->publish_now) ? $request->publish_now : 0;

            if ($request->hasFile('photos_main')) {
                $newImage = $request->file('photos_main');
                $newImageHash = md5_file($newImage->getRealPath());

                // Check if the existing image file exists
                $oldImagePath = public_path('uploads/ads/' . $ad->alt);
                if (file_exists($oldImagePath)) {
                    $oldImageHash = md5_file($oldImagePath);

                    // If the old and new images are the same, skip the update
                    if ($newImageHash === $oldImageHash) {
                        return redirect()->back()->with('success', 'pub mis à jour avec succès (aucune modification d\'image).');
                    }

                    // Delete the old image if they are different
                    @unlink($oldImagePath);
                }

                // Process and save the new image
                $newImageName = Str::random(8) . time() . '.' . $newImage->extension();
                $img = Image::make($newImage);
                $img->resize(1920, 1280);
                $img->save(public_path('uploads/ads/' . $newImageName), 100);

                // Update the ad with the new image
                $ad->alt = $newImageName;
            }

            $ad->save();

            return redirect()->back()->with('success', 'pub modifier avec succés.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['adError' => 'pub not modifier']);
        }
    }


    public function incrementViewCount($id)
    {
        try {
            $ad = Ad::findOrFail($id);
        $ad->increment('view_count');
        Statistique::create([
            'user_id' => $id,
            'action_type' => "ads",

            'ip'=>request()->ip()
        ]);
        return redirect($ad->url);
        } catch (\Throwable $e) {
            return redirect()->back();

        }
        
    }

    public function delete($id)
    {
        try {
            $user = auth()->user();
            if (!$user->isAdmin()) {
                return redirect()->back();
            }
            $Ad = Ad::find($id);
            $Ad->delete();
            return redirect()->back()->with("success","Publicité est supprimé");
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }
}

