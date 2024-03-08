<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Filial;
use App\Models\Admin;
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
            return view('home');
        }
    }
    
}
