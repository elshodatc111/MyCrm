<?php

namespace App\Http\Controllers;

use App\Models\Eslatma;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EslatmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
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
    public function destroy(Eslatma $eslatma)
    {
        //
    }
}
