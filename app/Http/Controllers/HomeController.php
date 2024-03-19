<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Filial;
use App\Models\Admin;
use App\Models\User;
use App\Models\Room;
use App\Models\Guruh;
use App\Models\GuruhJadval;
use App\Models\Eslatma;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        if((!request()->cookie('filial_id')) AND (!request()->cookie('filial_name'))){
            return redirect()->route('setCookie');
        }
        $user = Auth::user();
        if($user->type=='user'){
            return "Talaba profeli ishlab chiqilmoqda";
        }elseif ($user->type=='Techer') {
            return "O'qituvchi profeli tayyor emas";
        }else{
            $Statistika = array();
            $Statistika['techers'] = count(User::where('filial',request()->cookie('filial_id'))->where('type','Techer')->get());
            $Statistika['tashriflar'] = count(User::where('filial',request()->cookie('filial_id'))->where('type','user')->get());
            $Statistika['guruhlar'] = count(Guruh::where('filial',request()->cookie('filial_id'))->get());
            ### Dars Jadvali START ###
            $currentTime = time();
            $weekStart = strtotime('last Monday', $currentTime);
            $Room = Room::where('filial_id',request()->cookie('filial_id'))->get();
            $room_id = 1;
            $Xonalar = array();
            foreach($Room as $item){
                $Jadval = array();
                for ($k = 1; $k <= 9; $k++) {
                    for ($i = 0; $i < 6; $i++) {
                        $day = date('Y-m-d', strtotime("+$i days", $weekStart));
                        $GuruhJadval = GuruhJadval::where('room_id',$room_id)->where('times',$k)->where('days',$day)->get();
                        if(count($GuruhJadval)>=1){
                            $guruh_id = $GuruhJadval->first()->guruh_id;
                            $guruh_name = Guruh::where('id',$guruh_id)->get()->first()->guruh_name;
                            $Jadval[$i][$k]['guruh_id'] = $guruh_id;
                            $Jadval[$i][$k]['guruh_name'] = $guruh_name;
                        }else{
                            $Jadval[$i][$k] = "| Yoq |";
                        }

                    }
                }
                $Xonalar[$item->id] = $Jadval;
            }
            ### Dars Jadval END ###
            
                

            dd($Xonalar);
            
            #return view('home',compact('Statistika','Xonalar','Room'));
        }
    }
    
}
