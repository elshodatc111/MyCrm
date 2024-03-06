<?php

namespace App\Http\Controllers;

use App\Models\Filial;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FilialController extends Controller{
    public function index(){
        if(Auth::user()->type!=='SuperAdmin'){
            return redirect()->route('home');
        }else{
            $Filial = DB::table('filials')->join('users','filials.user_id','users.id')
            ->select('filials.filial_name','filials.filial_addres','filials.created_at','users.email','filials.id')->get();
            return view('filial.home', compact('Filial'));
        }
    }

    public function create(){
        if(Auth::user()->type!=='SuperAdmin'){
            return redirect()->route('home');
        }else{
            return view('filial.create');
        }
    }

    public function store(Request $request){
        if(Auth::user()->type!=='SuperAdmin'){
            return redirect()->route('home');
        }else{
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
        dd("Filial o'chirishdan oldin. Bazadagi barcha filialga tegishli malumotlarni o'chirish kerak.");
        $filial->delete();
        return redirect()->route('filial.index')->with('delete', 'Filial o\'chirildi. Malumotlarni qayta tiklash imkonitati mavjud emas.');
    }
}
