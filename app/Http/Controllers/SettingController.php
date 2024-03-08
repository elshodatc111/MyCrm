<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller{
    public function index(){
        $Setting = Setting::get();
        return view('setting.index',compact('Setting'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request){
        $validated = $request->validate([
            "summa" => ['required'],
            "days" => ['required'],
            "chegirma" => ['required'],
            "admin_chegirma" => ['required'],
        ]);
        $validated['summa'] = str_replace(',','',$request->summa);
        $validated['chegirma'] = str_replace(',','',$request->chegirma);
        $validated['admin_chegirma'] = str_replace(',','',$request->admin_chegirma);
        Setting::create($validated);
        return redirect()->route('setting.index')->with('success','Yangi to\'lov summasi kiritildi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting){

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting){
        $setting->delete();
        return redirect()->route('setting.index')->with('success','To\'lov so\'mmasi o\'chirildi.');
    }
}
