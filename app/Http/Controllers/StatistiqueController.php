<?php

namespace App\Http\Controllers;

use App\Models\Statistique;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    public function save(Request $request){
        try {
            Statistique::create([
                'user_id' => $request->user_id,
                'action_type' => $request->action_type,

                'ip'=>request()->ip()
            ]);
            return response()->json(['success' => true]);

        } catch (\Throwable $e) {
            return response()->json(['success' => true]);
        }
    }

    public function display_number_ip(){
        try {
            $user_id=auth()->user()->id;

            $statistique=Statistique::where("user_id",$user_id)->where("action_type","displayed_number")->paginate(12);

            return view('dasboard_users.statistique.display_number',compact('statistique'));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }

    public function call_number_ip(){
        try {
            $user_id=auth()->user()->id;

            $statistique=Statistique::where("user_id",$user_id)->where("action_type","call")->paginate(12);

            return view('dasboard_users.statistique.call_number',compact('statistique'));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }

    public function send_mail_ip(){
        try {
            $user_id=auth()->user()->id;

            $statistique=Statistique::where("user_id",$user_id)->where("action_type","mail")->paginate(12);

            return view('dasboard_users.statistique.mail_send',compact('statistique'));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }


    public function slider_ip($id){
        try {
            // $user_id=auth()->user()->id;
// dd("ee")
            $statistique=Statistique::where("user_id",$id)->where("action_type","slider")->orderBy("created_at","desc")->paginate(12);
            // dd($statistique);
            return view('dashboard_admin.sliders.slider_ip',compact('statistique'));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }

    public function ads_ip($id){
        try {
            // $user_id=auth()->user()->id;

            $statistique=Statistique::where("user_id",$id)->where("action_type","ads")->orderBy("created_at","desc")->paginate(12);
            // dd($statistique);
            return view('dashboard_admin.ads.ad_ip',compact('statistique'));
        } catch (\Throwable $e) {
            return redirect()->back();
        }
    }
}
