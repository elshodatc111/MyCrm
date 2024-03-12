<?php

namespace App\Http\Controllers;

use App\Models\Eslatma;
use App\Models\User;
use App\Models\Guruh;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EslatmaController extends Controller{
    public function index(){
        $Eslatma = Eslatma::where('filial_id',request()->cookie('filial_id'))->where('status','true')->get();
        $ActivEslatma = array();
        foreach ($Eslatma as $key => $value) {
            $ActivEslatma[$key]['id'] = $value->id;
            $ActivEslatma[$key]['type'] = $value->type;
            $ActivEslatma[$key]['text'] = $value->text;
            $ActivEslatma[$key]['user_guruh_id'] = $value->user_guruh_id;
            $ActivEslatma[$key]['created_at'] = $value->created_at;
            $UserAdmin = User::where('id',$value->admin_id)->get()->first()->email;
            $ActivEslatma[$key]['admin'] = $UserAdmin;
            if($value->type=='guruh'){
                $StudentEmail = Guruh::where('id',$value->user_guruh_id)->get()->first()->guruh_name;
                $ActivEslatma[$key]['userGuruh'] = $StudentEmail;
            }else{
                $StudentEmail = User::where('id',$value->user_guruh_id)->get()->first()->name;
                $ActivEslatma[$key]['userGuruh'] = $StudentEmail;
            }
        }
        #dd($ActivEslatma);
        return view('eslatma.index',compact('ActivEslatma'));
    }

    public function arxivEslatma(){
        $Eslatma = Eslatma::where('filial_id',request()->cookie('filial_id'))->where('status','false')->get();
        $ActivEslatma = array();
        foreach ($Eslatma as $key => $value) {
            $ActivEslatma[$key]['id'] = $value->id;
            $ActivEslatma[$key]['type'] = $value->type;
            $ActivEslatma[$key]['text'] = $value->text;
            $ActivEslatma[$key]['user_guruh_id'] = $value->user_guruh_id;
            $ActivEslatma[$key]['created_at'] = $value->created_at;
            $ActivEslatma[$key]['updated_at'] = $value->updated_at;
            $UserAdmin = User::where('id',$value->admin_id)->get()->first()->email;
            $ActivEslatma[$key]['admin'] = $UserAdmin;
            if($value->type=='guruh'){
                $StudentEmail = Guruh::where('id',$value->user_guruh_id)->get()->first()->guruh_name;
                $ActivEslatma[$key]['userGuruh'] = $StudentEmail;
            }else{
                $StudentEmail = User::where('id',$value->user_guruh_id)->get()->first()->name;
                $ActivEslatma[$key]['userGuruh'] = $StudentEmail;
            }
        }
        #dd($ActivEslatma);
        return view('eslatma.arxiv',compact('ActivEslatma'));
    }
    
    public function create()
    {
        //
    }

    public function EslatmaUser(Request $request){
        $validated = $request->validate([
            'user_guruh_id' => 'required',
            'text' => 'required',
        ]);
        $validated['filial_id'] = intval(request()->cookie('filial_id'));
        $validated['admin_id'] = Auth::user()->id;
        $validated['status'] = 'true';
        $validated['type'] = 'user';
        $Eslatma = Eslatma::create($validated);
        return back()->withInput()->with('success', "Eslatma saqlandi.");
    }
    public function store(Request $request){
        $validated = $request->validate([
            'user_guruh_id' => 'required',
            'text' => 'required',
        ]);
        $validated['filial_id'] = intval(request()->cookie('filial_id'));
        $validated['type'] = 'guruh';
        $validated['status'] = 'true';
        $validated['admin_id'] = Auth::user()->id;
        #dd($validated);
        $Eslatma = Eslatma::create($validated);
        return back()->withInput()->with('success', "Eslatma saqlandi.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Eslatma $eslatma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Eslatma $eslatma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Eslatma $eslatma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Eslatma $eslatma){
        $eslatma->status = 'false';
        $eslatma->update();
        return back()->withInput()->with('success', "Eslatma o'chirildi.");
    }
}
