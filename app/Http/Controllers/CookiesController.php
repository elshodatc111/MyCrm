<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filial;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
class CookiesController extends Controller{
    public function changeFilial(){
        $Filial = Filial::get();
        return view('filial.change',compact("Filial"));
    }
    public function changeFilialEdit($id, $name){
        return redirect()
            ->route('home')
            ->withCookie('filial_id', $id, 1800)
            ->withCookie('filial_name', $name, 1800); 
    }
    public function setCookie(){
        if(!request()->cookie('filial_id')){
            if(Auth::user()->filial == 'NULL' AND Auth::user()->type == 'SuperAdmin'){
                return $this->changeFilial();   
            }else{
                $Filial_id = Auth::user()->filial;
                $Filial_name = Filial::find($Filial_id)->filial_name;
                return redirect()
                    ->route('home')
                    ->withCookie('filial_id', $Filial_id, 1800)
                    ->withCookie('filial_name', $Filial_name, 1800); 
            }
        }else{
            return view('home');
        }
        
    }

    public function getCookie(){
        return request()->cookie('filial_id');
    }

    public function delCookie(){
        return response('deleted')->cookie('filial_id', null, -1800)->cookie('filial_name', null, -1800);
    }
}
