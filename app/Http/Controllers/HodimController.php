<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filial;
use Illuminate\Support\Facades\Auth;
class HodimController extends Controller{
    public function index(){
        if((!request()->cookie('filial_id')) AND (!request()->cookie('filial_name'))){
            return redirect()->route('setCookie');
        }
        return view('hodim.home');
    }

    public function create(){
        if((!request()->cookie('filial_id')) AND (!request()->cookie('filial_name'))){
            return redirect()->route('setCookie');
        }
        return view('hodim.create');
    }

    public function hodimLock(){
        if((!request()->cookie('filial_id')) AND (!request()->cookie('filial_name'))){
            return redirect()->route('setCookie');
        }
        return view('hodim.home-lock');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
