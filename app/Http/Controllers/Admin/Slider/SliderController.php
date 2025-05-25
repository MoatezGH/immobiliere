<?php

namespace App\Http\Controllers\Admin\Slider;

use App\Models\Slider;
use App\Models\Statistique;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    
    public function index()
    {

        try {
            $user = auth()->user();
        if (!$user->isAdmin()) {
            return redirect()->back();
        }
        $sliders = Slider::orderBy("created_at","desc")->paginate(8);
        // dd($sliders);
        return view("dashboard_admin.sliders.index", compact("sliders"));
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

        return view("dashboard_admin.sliders.add");
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
            $property = new Slider();

            $property->description = $request->title;
            $property->url = $request->lien;
            $property->active =
                isset($request->publish_now) ? $request->publish_now : 0;
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
                $img->save(public_path('uploads/sliders/' . $imgpath), 100);


                $property->alt = $imgpath;


                // Update the property's image_id with the ID of the new main picture

                // $property->save();
            }
            $property->save();

            return redirect()->back()->with('success', 'Slider crée avec succés.');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->withErrors(['propertyError' => 'Slider ne pas enregistrer']);
        }
    }

    public function edit($id)
    {
        try {
            $user = auth()->user();
            if (!$user->isAdmin()) {
                return redirect()->back();
            }
            $slider = Slider::find($id);
            return view("dashboard_admin.sliders.edit", compact('slider'));
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

            $property = Slider::findOrFail($id);

            $property->description = $request->title;
            $property->url = $request->lien;
            $property->active = isset($request->publish_now) ? $request->publish_now : 0;

            if ($request->hasFile('photos_main')) {
                $newImage = $request->file('photos_main');
                $newImageHash = md5_file($newImage->getRealPath());

                // Check if the existing image file exists
                $oldImagePath = public_path('uploads/sliders/' . $property->alt);
                if (file_exists($oldImagePath)) {
                    $oldImageHash = md5_file($oldImagePath);

                    // If the old and new images are the same, skip the update
                    if ($newImageHash === $oldImageHash) {
                        return redirect()->back()->with('success', 'Slider mis à jour avec succès (aucune modification d\'image).');
                    }

                    // Delete the old image if they are different
                    @unlink($oldImagePath);
                }

                // Process and save the new image
                $newImageName = Str::random(8) . time() . '.' . $newImage->extension();
                $img = Image::make($newImage);
                $img->resize(1920, 1280);
                $img->save(public_path('uploads/sliders/' . $newImageName), 100);

                // Update the property with the new image
                $property->alt = $newImageName;
            }

            $property->save();

            return redirect()->back()->with('success', 'Slider mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['propertyError' => 'Slider non enregistré: ' ]);
        }
    }

    public function incrementViewCount(Request $request)
    {
        try {
            $slider = Slider::findOrFail($request->id);
            $slider->increment('view_count');
            Statistique::create([
                'user_id' => $request->id,
                'action_type' => "slider",

                'ip'=>request()->ip()
            ]);
            return response()->json(['url' => $slider->url]);
        } catch (\Throwable $e) {
            // Optionally log the error
            // Log::error($e);
            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
        
    }

    public function delete($id)
    {
        try {
            $user = auth()->user();
            if (!$user->isAdmin()) {
                return redirect()->back();
            }
            $slider = Slider::find($id);
            $slider->delete();
            return redirect()->back()->with("success","Slider est supprimé");
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }

}
