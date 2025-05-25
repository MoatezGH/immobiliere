<?php

namespace App\Http\Controllers\Admin;

use App\Models\Property;
use App\Models\Statistique;
use Illuminate\Http\Request;
use App\Models\PromoteurProperty;
use App\Http\Controllers\Controller;

class StatistiqueAdminController extends Controller
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
    public function statUser($id,$type)
    {
        try {
            // dd($id);
            $call = Statistique::where("user_id", $id)->where("action_type", "call")->count();

            $displayed_number = Statistique::where("user_id", $id)->where("action_type", "displayed_number")->count();

            $mail = Statistique::where("user_id", $id)->where("action_type", "mail")->count();



            switch ($type) {
                case 'Entreprise':
                    // $user = auth()->user()->company;
                    $propstot = Property::where("user_id",$id)->count();
                    $propsViewtot = Property::where("user_id",$id)->sum('count_views');
                    // dd($propsViewtot);
                    $propstotActive = Property::where("user_id",$id)->where('state', 'valid')->count();

                    $props = Property::where("user_id",$id)
                        ->latest()
                        ->take(7)
                        ->get();
                    break;
                    
                case 'Particulier':
                    // $user = auth()->user()->particular;
                    $propstot = Property::where("user_id",$id)->count();
                    $propsViewtot = Property::where("user_id",$id)->sum('count_views');
                    // dd($propsViewtot);
                    $propstotActive = Property::where("user_id",$id)->where('state', 'valid')->count();
                    $props = Property::where("user_id",$id)
                        ->latest()
                        ->take(7)
                        ->get();
                    break;

                default:
                    // $user = auth()->user()->promoteur;
                    $propstot = PromoteurProperty::where("user_id", $id)->count();
                    $propstotActive = PromoteurProperty::where("user_id",$id)->where('status', '1')->count();
                    $props = PromoteurProperty::where("user_id",$id)
                        ->latest()
                        ->take(7)
                        ->get();
                    $propsViewtot = PromoteurProperty::where("user_id",$id)->sum('count_views');
                    break;
            }
// dd($id);
            return view("dashboard_admin.statistique.index",compact("call","displayed_number","mail","id",'props', 'propstotActive', 'propstot',"propsViewtot"));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }



    public function display_number_ip($id){
        try {
            // dd("eee");
// dd($id);
            
            $statistique=Statistique::where("user_id",$id)->where("action_type","displayed_number")->paginate(12);

            return view('dashboard_admin.statistique.display_number',compact('statistique'));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }

    public function call_number_ip($id){
        try {
            
            $statistique=Statistique::where("user_id",$id)->where("action_type","call")->paginate(12);
            // dd($statistique);
            return view('dashboard_admin.statistique.call_number',compact('statistique'));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }

    public function send_mail_ip($id){
        try {
            

            $statistique=Statistique::where("user_id",$id)->where("action_type","mail")->paginate(12);

            // dd($statistique);

            return view('dashboard_admin.statistique.mail_send',compact('statistique'));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }
}
