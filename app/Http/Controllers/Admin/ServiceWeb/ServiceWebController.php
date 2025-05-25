<?php

namespace App\Http\Controllers\Admin\ServiceWeb;

use App\Models\ServiceWeb;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ServiceWebController extends Controller
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

        $sliders = ServiceWeb::orderBy("created_at","desc")->paginate(8);
        // dd(ServiceWeb::all());
        return view("dashboard_admin.serviceWeb.index", compact("sliders"));
        } catch (\Throwable $e) {
            // dd($e->getMessage());
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

        return view("dashboard_admin.serviceWeb.add");
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
            $property = new ServiceWeb();

            $property->title = $request->title;
            $property->description = $request->description;
            $property->lien = $request->lien;
            $property->active =
                isset($request->publish_now) ? $request->publish_now : 0;
            if ($request->hasFile('photos_main')) {
                $image = $request->photos_main;

                $img = Image::make($image);
                $extension = $image->extension();
                $str_random = Str::random(8);
                // $img->resize(729, 398);
                // $img->resize(
                //     300,
                //     300
                // );

                $imgpath = $str_random . time() . "." . $extension;

                // Save the resized image
                $img->save(public_path('uploads/serviceWeb/' . $imgpath), 90);


                $property->imageUrl = $imgpath;


                // Update the property's image_id with the ID of the new main picture

                // $property->save();
            }
            $property->save();

            return redirect()->back()->with('success', 'Service crée avec succés.');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->withErrors(['propertyError' => 'Service ne pas enregistrer']);
        }
    }

    public function edit($id)
    {
        try {
            $user = auth()->user();
            if (!$user->isAdmin()) {
                return redirect()->back();
            }
            $slider = ServiceWeb::find($id);
            return view("dashboard_admin.serviceWeb.edit", compact('slider'));
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

            $property = ServiceWeb::findOrFail($id);

            $property->title = $request->title;
            $property->description = $request->description;

            $property->lien = $request->lien;
            $property->active = isset($request->publish_now) ? $request->publish_now : 0;

            if ($request->hasFile('photos_main')) {
                $newImage = $request->file('photos_main');
                $newImageHash = md5_file($newImage->getRealPath());

                // Check if the existing image file exists
                $oldImagePath = public_path('uploads/serviceWeb/' . $property->imageUrl);
                if (file_exists($oldImagePath)) {
                    $oldImageHash = md5_file($oldImagePath);

                    // If the old and new images are the same, skip the update
                    if ($newImageHash === $oldImageHash) {
                        return redirect()->back()->with('success', 'Service mis à jour avec succès (aucune modification d\'image).');
                    }

                    // Delete the old image if they are different
                    @unlink($oldImagePath);
                }

                // Process and save the new image
                $newImageName = Str::random(8) . time() . '.' . $newImage->extension();
                $img = Image::make($newImage);
                // $img->resize(1920, 1280);
                $img->save(public_path('uploads/serviceWeb/' . $newImageName), 100);

                // Update the property with the new image
                $property->imageUrl = $newImageName;
            }

            $property->save();

            return redirect()->back()->with('success', 'Service mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['propertyError' => 'Service non enregistré: '.$e->getMessage() ]);
        }
    }

   

}