<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Filial;

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
            return view('users.index');
        }elseif ($user->type=='techer') {
            return view('techers.index');
        }else{
            return view('home');
        }
    }
    
}
