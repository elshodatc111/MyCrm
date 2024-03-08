<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Test;
use Illuminate\Http\Request;

class SettingController extends Controller{
    public function index(){
        $Test = Test::where('status','true')->get();
        $Setting = Setting::where('filial_id',request()->cookie('filial_id'))->get();
        return view('setting.index',compact('Setting','Test'));
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
        $validated['filial_id'] = request()->cookie('filial_id');
        $validated['summa'] = str_replace(',','',$request->summa);
        $validated['chegirma'] = str_replace(',','',$request->chegirma);
        $validated['admin_chegirma'] = str_replace(',','',$request->admin_chegirma);
        Setting::create($validated);
        return redirect()->route('setting.index')->with('success','Yangi to\'lov summasi kiritildi.');
    }

    public function testCreate(Request $request){
        $validated = $request->validate([
            "test_name" => ['required'],
        ]);
        $validated['status'] = 'true';
        Test::create($validated);
        return redirect()->route('setting.index')->with('success','Yangi test kiritildi.');
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
    public function edit($id){
        $Test = Test::find($id);
        return view('setting.test_edit',compact('Test'));
    }

    public function update(Request $request,$id){
        $Test = Test::find($id);
        $Test->test_name = $request->test_name;
        $Test->update();
        return redirect()->route('setting.index')->with('success','Test yangilandi.');
    }

    public function testFalse($id){
        $Test = Test::find($id);
        $Test->status='false';
        $Test->update();
        return redirect()->route('setting.index')->with('success','Test o\'chirildi.');
    }
    public function destroy(Setting $setting){
        $setting->delete();
        return redirect()->route('setting.index')->with('success','To\'lov so\'mmasi o\'chirildi.');
    }
}
