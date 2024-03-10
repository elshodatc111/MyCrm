<?php

namespace App\Http\Controllers;

use App\Models\GuruhUser;
use App\Models\Guruh;
use App\Models\StudenHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class GuruhUserController extends Controller
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

    /**
     * Talabani gutuhga qo'shish
     */
    public function store(Request $request){
        $validated = $request->validate([
            "user_id" => ['required'],
            "guruh_id" => ['required'],
            "start_commit" => ['required'],
        ]);
        $validated['start_data'] = date('Y-m-d');
        $validated['start_meneger'] = Auth::user()->id;
        $validated['status'] = 'true';
        $validated['end_data'] = "NULL";
        $validated['end_commit'] = "NULL";
        $validated['end_meneger'] = "NULL";
        $History = GuruhUser::where('user_id','=',$request->user_id)->where('guruh_id','=',$request->guruh_id)->get();
        if(count($History)>0){
            return redirect()->route('user.show',$request->user_id)->with('success','Yangi guruhga qo\'shildi.');
        }else{
            GuruhUser::create($validated);
            $summa = Guruh::where('id',$request->guruh_id)->get()->first()->guruh_price;
            $status = 'GuruhPlus';
            $type = 0;
            $guruh_id = $request->guruh_id;
            $admin_id = Auth::user()->id;
            $student_id = $request->user_id;
            $filial_id = request()->cookie('filial_id');
            $historys = new StudenHistory();
            $historys->summa = -$summa;
            $historys->status = $status;
            $historys->type = $type;
            $historys->guruh_id = $guruh_id;
            $historys->admin_id = $admin_id;
            $historys->student_id = $student_id;
            $historys->filial_id = $filial_id;
            $historys-> save();
            return redirect()->route('user.show',$request->user_id)->with('success','Yangi guruhga qo\'shildi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GuruhUser $guruhUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuruhUser $guruhUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $validated = $request->validate([
            "end_commit" => ['required'],
        ]);
        $validated['end_data']=date('Y-m-d');
        $validated['status']='false';
        $validated['end_meneger']=Auth::user()->id;
        $GuruhUser = GuruhUser::where('guruh_id',$id)
        ->where('user_id',$request->user_id)->get()->first();
        $GuruhUser->update($validated);

        $validated2 = array();
        $validated2['filial_id']=request()->cookie('filial_id');
        $validated2['student_id']=$request->user_id;
        $validated2['status']='GuruhDelete';
        $validated2['summa']=$request->guruh_summa;
        $validated2['type']=0;
        $validated2['admin_id']=Auth::user()->id;
        $validated2['guruh_id']=$id;

        $validated3 = array();
        $validated3['filial_id']=request()->cookie('filial_id');
        $validated3['student_id']=$request->user_id;
        $validated3['status']='GuruhDelete';
        $validated3['summa']=-$request->summa_jarima;
        $validated3['type']=0;
        $validated3['admin_id']=Auth::user()->id;
        $validated3['guruh_id']=$id;
        #dd($request);
        StudenHistory::create($validated2);
        StudenHistory::create($validated3);
        return redirect()->route('guruh.show',$id)->with('success','Guruhdan talaba o\'chirildi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuruhUser $guruhUser)
    {
        //
    }
}
