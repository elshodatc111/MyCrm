<?php

namespace App\Http\Controllers;

use App\Models\Eslatma;
use App\Models\User;
use App\Models\Guruh;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EslatmaController extends Controller{
    public function index(){
        $Eslatma = Eslatma::where('status','true')->orderby('id','desc')->get();
        $Eslatmalar = array();
        foreach ($Eslatma as $key => $value) {
            $Eslatmalar[$key]['id']=$value->id;
            $Eslatmalar[$key]['text']=$value->text;
            $Eslatmalar[$key]['type']=$value->type;
            $Eslatmalar[$key]['user_guruh_id']=$value->user_guruh_id;
            $Eslatmalar[$key]['created_at']=$value->created_at;
            if($value->type=='user'){
                $User = User::where('id',$value->user_guruh_id)->get()->first();
                $Eslatmalar[$key]['name']=$User->name;
            }else{
                $Guruh = Guruh::where('id',$value->user_guruh_id)->get()->first();
                $Eslatmalar[$key]['name']=$Guruh->guruh_name;
            }
        }
        return view('eslatma.index',compact('Eslatmalar'));
    }

    public function arxivEslatma(){
        $Eslatma = Eslatma::where('status','false')->orderby('id','desc')->get();
        $Eslatmalar = array();
        foreach ($Eslatma as $key => $value) {
            $Eslatmalar[$key]['id']=$value->id;
            $Eslatmalar[$key]['text']=$value->text;
            $Eslatmalar[$key]['type']=$value->type;
            $Eslatmalar[$key]['updated_at']=$value->updated_at;
            $Eslatmalar[$key]['user_guruh_id']=$value->user_guruh_id;
            $Eslatmalar[$key]['created_at']=$value->created_at;
            if($value->type=='user'){
                $User = User::where('id',$value->user_guruh_id)->get()->first();
                $Eslatmalar[$key]['name']=$User->name;
            }else{
                $Guruh = Guruh::where('id',$value->user_guruh_id)->get()->first();
                $Eslatmalar[$key]['name']=$Guruh->guruh_name;
            }
        }
        return view('eslatma.arxiv',compact('Eslatmalar'));
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
        return back()->withInput()->with('success', "Eslatma tasdiqlandi.");
    }
}
