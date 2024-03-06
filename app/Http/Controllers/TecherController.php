<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Techer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class TecherController extends Controller{
    public function index(){
        $Techer = DB::table('users')
        ->join('techers', 'users.id', 'techers.user_id')
        ->where('users.status','true')
        ->select('users.name','users.phone','users.email','users.tkun','users.address','users.id')
        ->where('users.filial',request()->cookie('filial_id'))->get();
        return view('techers.index', compact('Techer'));
    }

    public function techerLock(){
        $Techer = DB::table('users')
        ->join('techers', 'users.id', 'techers.user_id')
        ->where('users.status','false')
        ->select('users.name','users.phone','users.email','users.tkun','users.address','users.id')
        ->where('users.filial',request()->cookie('filial_id'))->get();
        return view('techers.techer-lock', compact('Techer'));
    }

    public function techerLockopen(string $id){
        $Techer = User::find($id);
        $Techer->status = 'false';
        $Techer->update();
        return redirect()->route('techer.index')->with('success','O\'qituvchi bloklandi.');
    }
    public function techerLockClose(string $id){
        $Techer = User::find($id);
        $Techer->status = 'true';
        $Techer->update();
        return redirect()->route('techer.index')->with('success','O\'qituvchi aktivlashtirildi.');
    }
    
    public function create(){
        return view('techers.create');
    }
    public function store(Request $request){
        $validated = $request->validate([
            "name" => ['required'],
            "address" => ['required'],
            "phone" => ['required'],
            "tkun" => ['required'],
            "email" => ['required','unique:users'],
            "password" => ['required','max:8'],
        ]);
        $validated['password'] = Hash::make($request['password']);
        $validated['status'] = 'true';
        $validated['type'] = 'Techer';
        $validated['filial'] = request()->cookie('filial_id');
        User::create($validated);
        $Users = DB::table('users')->where('email',$request->email)->get()->first();
        $user_id = $Users->id;

        $validated2 = $request->validate([
            "TecherAbout" => ['required'],
            "Mutahasisligi" => ['required'],
        ]);
        $validated2['user_id'] = $user_id;
        Techer::create($validated2);
        return redirect()->route('techer.index')->with('success','O\'qituvchi qo\'shildi.');
    }

    public function show(string $id){
        return view('techers.show');
    }

    public function edit(string $id){
        $Techer = DB::table('users')->join('techers','users.id','techers.user_id')->where('users.id','=',$id)->get()->first();
        return view('techers.edit',compact('Techer'));
    }
    public function update(Request $request, string $id){
        $validated = $request->validate([
            "name" => ['required'],
            "address" => ['required'],
            "phone" => ['required'],
            "tkun" => ['required'],
            "password" => ['required','max:8'],
        ]);
        $validated2 = $request->validate([
            "TecherAbout" => ['required'],
            "Mutahasisligi" => ['required']
        ]);
        $Techer = DB::table('users')->where('id',$id)->update($validated);
        $About = DB::table('techers')->where('user_id',$id)->update($validated2);
        return redirect()->route('techer.index')->with('success','O\'qituvchi malumotlari yangilandi.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}