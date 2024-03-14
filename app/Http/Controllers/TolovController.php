<?php

namespace App\Http\Controllers;
use App\Models\Tolov;
use App\Models\Guruh;
use App\Models\UserHistory;
use App\Models\StudenHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use Illuminate\Http\Request;

class TolovController extends Controller{
    public function index(){
        //
    }

    public function create(){
        //
    }
    
    
    ### Talaba Tulovlarini qabul qilish CRM orqali ###
    public function store(Request $request){
        $validated = $request->validate([
            "naqtSumma" => ['required'],
            "guruh_id" => ['required'],
            "plastikSumma" => ['required'],
            "commit" => ['required'],
            'user_id'=>['required']
        ]);
        
        dd($validated);
        #return back()->withInput();
    }

    public function show(Tolov $tolov){
        
    }

    public function edit(Tolov $tolov){
        //
    }

    public function update(Request $request, Tolov $tolov){
        //
    }

    public function destroy(Tolov $tolov)
    {
        //
    }
}
