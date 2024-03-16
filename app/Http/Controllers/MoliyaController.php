<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Talaba;
use App\Models\UserHistory;
use App\Models\StudenHistory;
use App\Models\Guruh;
use App\Models\Tolov;
use App\Models\GuruhUser;
use App\Models\Eslatma;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MoliyaController extends Controller{
    public function index(){
        ## Naqt tulovlar Summasi
        $NaqtTulov = UserHistory::where('filial_id', request()->cookie('filial_id'))->where('status', 'TulovNaqt')->where('type', 'false')->get();
        $Naqt = 0;
        foreach ($NaqtTulov as $key => $value) {$Naqt = $Naqt + $value->summa;}
        $Naqt1 = number_format(($Naqt), 0, '.', ' ');
        ## Plastik to'lovlar
        $PlastikTulov = UserHistory::where('filial_id', request()->cookie('filial_id'))->where('status', 'TulovPlastik')->where('type', 'false')->get();
        $Plastik = 0;
        foreach ($PlastikTulov as $key => $value) {$Plastik = $Plastik + $value->summa;}
        $Plastik1 = number_format(($Plastik), 0, '.', ' ');
        return view('moliya.index', compact('Naqt1','Plastik1'));
    }

    public function naqtMoliya(){
        $Tulovlar = array();
        $NaqtTulov = UserHistory::where('filial_id', request()->cookie('filial_id'))
        ->where('status', 'TulovNaqt')->where('type', 'false')->get();
        #dd($NaqtTulov->summa);
        foreach ($NaqtTulov as $key => $value) {
            $Tulovlar[$key]['id'] = $value->id;
            $User_studnemt = User::where('id',$value->student_id)->get()->first();
            $Tulovlar[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $Tulovlar[$key]['student_id'] = $value->student_id;
            $Tulovlar[$key]['created_at'] = $value->created_at;
            $Tulovlar[$key]['admin_id'] = $value->admin_id;
            $User_admin = User::where('id',$value->admin_id)->get()->first();
            $Tulovlar[$key]['user_name'] = $User_studnemt->name;
            $Tulovlar[$key]['admin_email'] = $User_admin->email;
            $Tulov = Tolov::where('id',$value->tulov_id)->get()->first();
            if($Tulov->guruh_id==='NULL'){
                $Tulovlar[$key]['guruh'] = "Guruh tanlanmagan.";
            }else{
                $Guruh = Guruh::where('id',$Tulov->guruh_id)->get()->first();
                $Tulovlar[$key]['guruh'] = $Guruh->guruh_name;
            }
            $Tulovlar[$key]['izoh'] = $value->izoh;
        }
        #dd($Tulovlar);
        return view('moliya.naqt',compact('Tulovlar'));
    }
    public function CheckEdit(Request $request, string $id){
        $AdminHistory = UserHistory::where('id',$id)->get()->first();
        $AdminHistory->type = 'true';
        $AdminHistory->update();
        return back()->withInput()->with('success',"To'lov tasdiqlandi.");
    }
    public function CheckDestroy(Request $request, string $id){
        $AdminHistory = UserHistory::where('id',$id)->get()->first();
        $StudenHistory =  StudenHistory::where('tulov_id',$AdminHistory->tulov_id)->get()->first();
        $Tulov = Tolov::where('id',$AdminHistory->tulov_id)->get()->first();
        $AdminHistory->delete();
        $StudenHistory->delete();
        $Tulov->delete();
        return back()->withInput()->with('success',"To'lov o'chirildi.");
        dd($StudenHistory);
    }

    public function plastikMoliya(){
        $Tulovlar = array();
        $NaqtTulov = UserHistory::where('filial_id', request()->cookie('filial_id'))
        ->where('status', 'TulovPlastik')->where('type', 'false')->get();
        #dd($NaqtTulov->summa);
        foreach ($NaqtTulov as $key => $value) {
            $Tulovlar[$key]['id'] = $value->id;
            $User_studnemt = User::where('id',$value->student_id)->get()->first();
            $Tulovlar[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $Tulovlar[$key]['student_id'] = $value->student_id;
            $Tulovlar[$key]['created_at'] = $value->created_at;
            $Tulovlar[$key]['admin_id'] = $value->admin_id;
            $User_admin = User::where('id',$value->admin_id)->get()->first();
            $Tulovlar[$key]['user_name'] = $User_studnemt->name;
            $Tulovlar[$key]['admin_email'] = $User_admin->email;
            $Tulov = Tolov::where('id',$value->tulov_id)->get()->first();
            if($Tulov->guruh_id==='NULL'){
                $Tulovlar[$key]['guruh'] = "Guruh tanlanmagan.";
            }else{
                $Guruh = Guruh::where('id',$Tulov->guruh_id)->get()->first();
                $Tulovlar[$key]['guruh'] = $Guruh->guruh_name;
            }
            $Tulovlar[$key]['izoh'] = $value->izoh;
        }
        return view('moliya.plastik',compact('Tulovlar'));
    }

    public function qaytarildiMoliya(){
        
    }

    public function xarajatMoliya(){
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
