<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Category;
use App\Models\Property;
use App\Models\Operation;
use Illuminate\Http\Request;
use App\Models\PromoteurProperty;

class PromoteurController extends Controller
{
    public function get_add()
    {
        $userAccount = auth()->user()->checkType();
        // dd($userType);

        switch ($userAccount) {
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

        $logo = Logo::find($user->logo_id);
        $operations = Operation::all();
        $categories = Category::all();
        $cities = City::all();
        // $areas = Area::where("city_id", auth()->user()->city_id)->get();
        $situations = Situation::all();
        $areas =  Area::class;

        if ($userAccount == "promoteur") {
            // dd('fff000');
            return view('dasboard_users.properties.promoteur.add', compact('logo', 'operations', 'categories', 'cities', 'situations', 'userAccount'));
        }
        return view('dasboard_users.properties.promoteur.add', compact('logo', 'operations', 'categories', 'cities', 'situations', 'userAccount', 'areas'));
    }

}
