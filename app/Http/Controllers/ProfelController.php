<?php

namespace App\Http\Controllers;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use App\Models\Xarajat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfelController extends Controller{
    public function index(){
        $Tasdiqlanmagan = UserHistory::where('filial_id',request()->cookie('filial_id'))->where('admin_id',Auth::user()->id)->where('type','false')->get();
        $Naqt = 0;
        $Plastik = 0;
        $Qaytar = 0;
        $Xarajat = 0;
        $Summa = array();
        foreach ($Tasdiqlanmagan as $key => $value) {if($value->status=='TulovNaqt'){$Naqt = $Naqt + $value['summa'];}elseif($value->status=='TulovPlastik'){$Plastik = $Plastik + $value['summa'];}elseif($value->status=='TulovQaytarildi'){$Qaytar = $Qaytar + $value['summa'];}}
        $Xarajatlar = Xarajat::where('filial_id',request()->cookie('filial_id'))->where('operator_id',Auth::user()->id)->where('type','false')->get();
        foreach ($Xarajatlar as $key => $value) {$Xarajat = $Xarajat + $value['summa'];}
        $Summa['Naqt'] = number_format(($Naqt), 0, '.', ' ');
        $Summa['Plastik'] = number_format(($Plastik), 0, '.', ' ');
        $Summa['Qaytar'] = number_format(($Qaytar*(-1)), 0, '.', ' ');
        $Summa['Xarajat'] = number_format(($Xarajat), 0, '.', ' ');
        return view('profel.index',compact('Summa'));
    }
    public function Statistika(){
        ### Start Joriy Oy ###
        $ThisMonch = date('Y-m');
        $ThisTashrif = count(UserHistory::where('filial_id',request()->cookie('filial_id'))->where('admin_id',Auth::user()->id)->where('created_at','>',$ThisMonch.'-01 00:00:00')->where('created_at','<',$ThisMonch.'-31 23:59:59')->where('status','Tashrif')->get());
        $Tasdiqlanmagan = UserHistory::where('filial_id',request()->cookie('filial_id'))->where('admin_id',Auth::user()->id)->where('created_at','>',$ThisMonch.'-01 00:00:00')->where('created_at','<',$ThisMonch.'-31 23:59:59')->where('type','true')->get();
        $Naqt = 0;
        $Plastik = 0;
        $Qaytar = 0;
        $Xarajat = 0;
        $Summa = array();
        foreach ($Tasdiqlanmagan as $key => $value) {if($value->status=='TulovNaqt'){$Naqt = $Naqt + $value['summa'];}elseif($value->status=='TulovPlastik'){$Plastik = $Plastik + $value['summa'];}elseif($value->status=='TulovQaytarildi'){$Qaytar = $Qaytar + $value['summa'];}}
        $Xarajatlar = Xarajat::where('filial_id',request()->cookie('filial_id'))->where('operator_id',Auth::user()->id)->where('created_at','>',$ThisMonch.'-01 00:00:00')->where('created_at','<',$ThisMonch.'-31 23:59:59')->where('type','true')->get();
        foreach ($Xarajatlar as $key => $value) {$Xarajat = $Xarajat + $value['summa'];}
        $Summa['Naqt'] = number_format(($Naqt), 0, '.', ' ');
        $Summa['Plastik'] = number_format(($Plastik), 0, '.', ' ');
        $Summa['Qaytar'] = number_format(($Qaytar*(-1)), 0, '.', ' ');
        $Summa['Xarajat'] = number_format(($Xarajat), 0, '.', ' ');  
        $Summa['ThisTashrif'] = number_format(($ThisTashrif), 0, '.', ' ');  
        ### END Joriy OY ###
        ### O'tgan oy ###
        $oldData = date('Y-m',strtotime('-1 month'));
        $OldTashrif = count(UserHistory::where('filial_id',request()->cookie('filial_id'))->where('admin_id',Auth::user()->id)->where('created_at','>',$oldData.'-01 00:00:00')->where('created_at','<',$oldData.'-31 23:59:59')->where('status','Tashrif')->get());
        $OldTasdiqlanmagan = UserHistory::where('filial_id',request()->cookie('filial_id'))->where('admin_id',Auth::user()->id)->where('created_at','>',$oldData.'-01 00:00:00')->where('created_at','<',$oldData.'-31 23:59:59')->where('type','true')->get();
        $OldNaqt = 0;
        $OldPlastik = 0;
        $OldQaytar = 0;
        $OldXarajat = 0;
        $OldSumma = array();
        foreach ($OldTasdiqlanmagan as $key => $value) {if($value->status=='TulovNaqt'){$OldNaqt = $OldNaqt + $value['summa'];}elseif($value->status=='TulovPlastik'){$OldPlastik = $OldPlastik + $value['summa'];}elseif($value->status=='TulovQaytarildi'){$OldQaytar = $OldQaytar + $value['summa'];}}
        $Xarajatlar = Xarajat::where('filial_id',request()->cookie('filial_id'))->where('operator_id',Auth::user()->id)->where('created_at','>',$oldData.'-01 00:00:00')->where('created_at','<',$oldData.'-31 23:59:59')->where('type','true')->get();
        foreach ($Xarajatlar as $key => $value) {$OldXarajat = $OldXarajat + $value['summa'];}
        $OldSumma['OldNaqt'] = number_format(($OldNaqt), 0, '.', ' ');
        $OldSumma['OldPlastik'] = number_format(($OldPlastik), 0, '.', ' ');
        $OldSumma['OldQaytar'] = number_format(($OldQaytar*(-1)), 0, '.', ' ');
        $OldSumma['OldXarajat'] = number_format(($OldXarajat), 0, '.', ' ');  
        $OldSumma['OldTashrif'] = number_format(($OldTashrif), 0, '.', ' '); 
        return view('profel.statistik', compact('Summa','OldSumma'));
    }
    public function IshHaqi(){
        return view('profel.ishhaqi');
    }

    public function create(){}

    public function store(Request $request){}

    public function show(string $id){}

    public function edit(string $id){}
    
    public function update(Request $request, string $id){
        $validated = $request->validate([
            "thispassword" => ['required','min:8'],
            "newpassword" => ['required','min:8'],
            "repetpassword" => ['required','min:8']
        ]);
        if($validated['newpassword']==$validated['repetpassword']){
            $password = Hash::make($request->thispassword);
            $email = Auth::user()->email;
            $User = User::where('email',$email)->first();
            if($User){
                $User->update([
                    'password'=>Hash::make($request->newpassword)
                ]);
                return back()->withInput()->with('success', "Parol yangilandi.");
            }else{
                return back()->withInput()->with('error', "Joriy parol mos kelmadi.");
            }
        }else{
            return back()->withInput()->with('error', "Yangi parol bir xil emas.");
        }
    }

    public function destroy(string $id){}
}
