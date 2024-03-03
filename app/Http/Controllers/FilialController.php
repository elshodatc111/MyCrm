<?php

namespace App\Http\Controllers;

use App\Models\Filial;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FilialController extends Controller{
    public function index(){
        if(Auth::user()->type!=='SuperAdmin'){
            return redirect()->route('home');
        }
        $Filial = Filial::get();
        $Users = User::get();
        return view('filial.home', compact('Filial', 'Users'));
    }

    public function create(){
        if(Auth::user()->type!=='SuperAdmin'){
            return redirect()->route('home');
        }
        return view('filial.create');
    }

    public function store(Request $request){
        if(Auth::user()->type!=='SuperAdmin'){
            return redirect()->route('home');
        }
        $validated = $request->validate([
            'filial_addres' => 'required',
            'filial_name' => 'required',
        ]);
        $validated['user_id'] = Auth::user()->id;
        $filial = new Filial();
        $filial->filial_addres = $validated['filial_addres'];
        $filial->filial_name = $validated['filial_name'];
        $filial->user_id = $validated['user_id'];
        $filial->save();
        return redirect()->route('filial.index')->with('message', 'Yangi filial ochildi');
    }

    public function show(Filial $filial){
        
    }

    public function edit(Filial $filial){
        return view('filial.edit',compact('filial'));
    }
    public function update(Request $request, Filial $filial){
        if(Auth::user()->type!=='SuperAdmin'){
            return redirect()->route('home');
        }
        $validated = $request->validate([
            'filial_addres' => 'required',
            'filial_name' => 'required',
        ]);
        $filial->update($validated);
        return redirect()->route('filial.index')->with('update', 'Filial yangilandi.');
    }
    public function destroy(Filial $filial){
        $filial->delete();
        return redirect()->route('filial.index')->with('delete', 'Filial o\'chirildi. Malumotlarni qayta tiklash imkonitati mavjud emas.');
    }
}
