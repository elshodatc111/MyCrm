<?php

namespace App\Http\Controllers;
use App\Models\IshHaqi;
use App\Models\IshHaqiTecher;
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
            return back()->withInput()->with('success',"Hodimga ish haqi to'landi.");
        }else{
            return back()->withInput()->with('error',"Kassada yetarli mablag' mavjud emas.");
        }
    }

    public function TecherPayIshHaqi(Request $request){
        $validated = $request->validate([
            'techer_id' => ['required',  'max:255'],
            "summa" => ['required',  'max:255'],
            "type" => ['required',  'max:255'],
            "guruh_id" => ['required',  'max:255'],
            "commit" => ['required',  'max:255'],
        ]);
        if($request->type=='Naqt' AND str_replace(',','',$request->summa)>str_replace(' ','',$request->Naqt) ){
            return back()->withInput()->with('error',"Kassada yetarli mablag' mavjud emas.");
        }if($request->type=='Plastik' AND str_replace(',','',$request->summa)>str_replace(' ','',$request->Plastik) ){
           return back()->withInput()->with('error',"Kassada yetarli mablag' mavjud emas."); 
        }else{
            $validated['summa'] = str_replace(",",'',$request->summa);
            $validated['filial_id'] = request()->cookie('filial_id');
            $validated['status'] = "Techer";
            $validated['admin_id'] = Auth::user()->id;
            IshHaqiTecher::create($validated);
            $Kassa = Kassa::where('filial_id',request()->cookie('filial_id'))->first();
            $Naqt = $Kassa->TecherPayNaqt;
            $Plastik = $Kassa->TecherPayPlastik;
            if($request->type=='Naqt'){
                $Kassa->TecherPayNaqt = $Naqt + str_replace(',','',$request->summa);
                $Kassa->save();
            }else{
                $Kassa->TecherPayPlastik = $Plastik + str_replace(',','',$request->summa);
                $Kassa->save();
            }
            return back()->withInput()->with('success',"O'qituvchiga ish haqi to'landi.");
        }
    }
}
