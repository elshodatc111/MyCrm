<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Filial;
use App\Models\Admin;
use App\Models\User;
use App\Models\Guruh;
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
        
           
            

            return view('home',compact('Statistika'));
        }
    }
    
}
