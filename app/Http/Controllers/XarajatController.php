<?php

namespace App\Http\Controllers;
use App\Models\Xarajat;
use App\Models\User;
use App\Models\Kassa;
use App\Models\UserHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class XarajatController extends Controller{
    public function KassadaMavJud(){
        $Tolov = UserHistory::where('filial_id',request()->cookie('filial_id'))->where('status','TulovNaqt')->where('type','true')->get();
        $Summa = 0;
        foreach($Tolov as $item){
            $Summa = $Summa + $item['summa'];
        }
        $TulovQaytarildi = UserHistory::where('filial_id',request()->cookie('filial_id'))->where('status','TulovQaytarildi')->where('type','false')->get();
        foreach($TulovQaytarildi as $item){
            $Summa = $Summa + $item['summa'];
        }
        $Kassa = Kassa::where('filial_id',request()->cookie('filial_id'))->first();
        $Chiqim = $Kassa->ChiqimNaqt +$Kassa->XarajatNaqt +$Kassa->HodimPayNaqt +$Kassa->TecherPayNaqt;
        
        return $Summa-$Chiqim;
    }

    public function index(){
        $Xarajat = Xarajat::where('filial_id',request()->cookie('filial_id'))->where('type','false')->get();
        $Xaralatlar = array();
        $Tasdiqlanmagan = 0;
        foreach ($Xarajat as $key => $value) {
            $Xaralatlar[$key]['id'] = $value->id;
            $Xaralatlar[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $Xaralatlar[$key]['comment'] = $value->comment;
            $Xaralatlar[$key]['operator'] = User::where('id',$value->operator_id)->get()->first()->email;
            $Xaralatlar[$key]['created_at'] = $value->created_at;
            $Tasdiqlanmagan = $Tasdiqlanmagan + $value['summa'];
        }
        $Kassa = number_format(($this->KassadaMavJud()-$Tasdiqlanmagan), 0, '.', ' ');
        $Tasdiqlanmagan = number_format(($Tasdiqlanmagan), 0, '.', ' ');
        return view('xarajat.index',compact('Kassa','Xaralatlar','Tasdiqlanmagan'));
    }

    public function store(Request $request){
        $Xarajat = Xarajat::where('filial_id',request()->cookie('filial_id'))->where('type','false')->get();
        $Tasdiqlanmagan = 0;
        foreach ($Xarajat as $key => $value) {
            $Tasdiqlanmagan = $Tasdiqlanmagan + $value['summa'];
        }
        $MavjudSumma = $this->KassadaMavJud()-$Tasdiqlanmagan;
        $validated = $request->validate([
            "summa" => ['required'],
            "comment" => ['required']
        ]);
        $validated['filial_id'] = request()->cookie('filial_id');
        $validated['type'] = 'false';
        $validated['operator_id'] = Auth::user()->id;
        $validated['admin_id'] = 'NULL';
        $validated['summa'] =  str_replace(",","",$request->summa);
        if($MavjudSumma>=$validated['summa']){
            Xarajat::create($validated);
            return back()->withInput()->with('success', "Xarajat uchun chiqim tasdiqlandi.");
        }else{
            return back()->withInput()->with('error', "Xarajat uchun kassada mablag' yetarli emas.");
        }
    }

    public function delete(string $id){
        $Xarajat = Xarajat::where('id',$id)->first();
        $Xarajat->delete();
        return back()->withInput()->with('success', "Xarajat uchun chiqim o'chirildi.");
    }

}
