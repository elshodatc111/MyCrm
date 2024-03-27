<?php

namespace App\Http\Controllers;
use App\Models\IshHaqi;
use App\Models\Kassa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IshHaqiController extends Controller{
    public function HodimPayIshHaqi(Request $request){
        $validated = $request->validate([
            "summa" => ['required',  'max:255'],
            "type" => ['required',  'max:255'],
            "commit" => ['required',  'max:255'],
        ]);
        $validated['filial_id'] = request()->cookie('filial_id');
        $validated['user_id'] = $request->id;
        $validated['status'] = "Hodim";
        $validated['summa'] = str_replace(',','',$request->summa);
        $validated['type'] = $request->type;
        $validated['commit'] = $request->commit;
        $validated['admin_id'] = Auth::user()->id;
        if($validated['type'] == 'Naqt'){
            $Kassada_Mavjud = str_replace(' ','',$request['Naqt']);
        }else{
            $Kassada_Mavjud = str_replace(' ','',$request['Plastik']);
        }
        if($validated['summa']<=$Kassada_Mavjud){
            IshHaqi::create($validated);
            $Kassa = Kassa::where('filial_id',request()->cookie('filial_id'))->first();
            $Naqt = $Kassa->HodimPayNaqt;
            $Plastik = $Kassa->HodimPayPlastik;
            if($request->type=='Naqt'){
                $Kassa->HodimPayNaqt = $Naqt + str_replace(',','',$request->summa);
                $Kassa->save();
            }else{
                $Kassa->HodimPayPlastik = $Plastik + str_replace(',','',$request->summa);
                $Kassa->save();
            }
            return back()->withInput()->with('success',"Hodim uchun ish haqi to'landi.");
        }else{
            return back()->withInput()->with('error',"Kassada yetarli mablag' mavjud emas.");
        }
    }
}
