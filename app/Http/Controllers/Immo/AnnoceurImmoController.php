<?php

namespace App\Http\Controllers\Immo;

use App\Models\Area;
use App\Models\City;
use App\Models\Logo;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\PromoteurProperty;
use App\Http\Controllers\Controller;
use App\Models\Statistique;
use Illuminate\Support\Facades\Auth;

class AnnoceurImmoController extends Controller
{
    public function dashboard()
    {
        try {
            if (Auth::check()) {
                // $user = auth()->user()->company;

                $userAccount = auth()->user()->checkType();
                // dd(auth()->user()->id);

                switch ($userAccount) {
                    case 'company':
                        $user = auth()->user()->company;
                        $propstot = Property::where("user_id", auth()->user()->id)->count();
                        $propsViewtot = Property::where("user_id", auth()->user()->id)->sum('count_views');
                        // dd($propsViewtot);
                        $propstotActive = Property::where("user_id", auth()->user()->id)->where('state', 'valid')->count();

                        $props = Property::where("user_id", auth()->user()->id)
                            ->latest()
                            ->take(7)
                            ->get();
                        break;
                        
                    case 'particular':
                        $user = auth()->user()->particular;
                        $propstot = Property::where("user_id", auth()->user()->id)->count();
                        $propsViewtot = Property::where("user_id", auth()->user()->id)->sum('count_views');
                        // dd($propsViewtot);
                        $propstotActive = Property::where("user_id", auth()->user()->id)->where('state', 'valid')->count();
                        $props = Property::where("user_id", auth()->user()->id)
                            ->latest()
                            ->take(7)
                            ->get();
                        break;

                    default:
                        $user = auth()->user()->promoteur;
                        $propstot = PromoteurProperty::where("user_id", auth()->user()->id)->count();
                        $propstotActive = PromoteurProperty::where("user_id", auth()->user()->id)->where('status', '1')->count();
                        $props = PromoteurProperty::where("user_id", auth()->user()->id)
                            ->latest()
                            ->take(7)
                            ->get();
                        $propsViewtot = PromoteurProperty::where("user_id", auth()->user()->id)->sum('count_views');
                        break;
                }

                $logo = null;
                if (auth()->user()->store) {
                    $logo = auth()->user()->store->logo;
                }
                $categories = Category::all();
                $call=Statistique::where("user_id",auth()->user()->id)->where("action_type","call")->count();

                $displayed_number=Statistique::where("user_id",auth()->user()->id)->where("action_type","displayed_number")->count();

                $mail=Statistique::where("user_id",auth()->user()->id)->where("action_type","mail")->count();
                // dd("test");
                return view('dasboard_users.dashboard_immo.index', compact('logo', 'userAccount', 'user', 'props', 'propstotActive', 'propstot', 'categories', 'propsViewtot',"call","displayed_number","mail"));
            }
            return redirect("login")->withSuccess('Vous n\'êtes pas autorisé à accéder');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
        
    }

    public function profile()
    {
        try {
            $cities = City::all();
            $areas = Area::where("city_id", auth()->user()->city_id)->get();

            // dd($areas);
            $userAccount = auth()->user()->checkType();
            switch ($userAccount) {
                case 'company':
                    $userType = auth()->user()->company;

                    break;
                case 'particular':
                    $userType = auth()->user()->particular;

                    break;

                default:
                    $userType = auth()->user()->promoteur;

                    break;
            }
            // dd($user);
            // dd($user->logo);
            // $logo = Logo::find($userType->logo_id);
            $logo = null;
            if (auth()->user()->store) {
                $logo = auth()->user()->store->logo;
            }
            // dd($logo);
            $categories = Category::all();
            return view('dasboard_users.dashboard_immo.profile', compact('cities', 'areas', 'logo', 'userType', 'userAccount', 'categories'));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }
}
