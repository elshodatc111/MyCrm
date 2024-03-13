<?php

namespace App\Http\Controllers;
use App\Models\Tolov;
use App\Models\Guruh;
use App\Models\Setting;
use Illuminate\Http\Request;

class TolovController extends Controller{
    public function index(){
        //
    }

    public function create(){
        //
    }
    
    public function store(Request $request){
        $validated = $request->validate([
            "naqtSumma" => ['required'],
            "guruh_id" => ['required'],
            "plastikSumma" => ['required'],
            "commit" => ['required'],
            'user_id'=>['required']
        ]);
        $validated['naqtSumma'] = str_replace(',',"",$request->naqtSumma);
        $validated['plastikSumma'] = str_replace(',',"",$request->plastikSumma);

        $ChegirmaSumma = Guruh::where('guruhs.id',$validated['guruh_id'])
            ->where('settings.filial_id',request()->cookie('filial_id'))
            ->join('settings','guruhs.guruh_price','settings.summa')
            ->select('settings.days','settings.summa','settings.chegirma')->get()->first();
        #dd($ChegirmaSumma);
        $Price = 0;
        if($validated['naqtSumma']!=0 || $validated['plastikSumma']!=0){
            $Price = $validated['naqtSumma']+$validated['plastikSumma'];
            #echo "Naqt + Plastik"; Naqt va Plastik tulovlar, user_history va admin_historyga yozilsin
        }elseif($validated['naqtSumma']!=0){
            $Price = $validated['naqtSumma'];
            #echo "Faqat Naqt"; Naqt tulovlar, user_history va admin_historyga yozilsin
        }elseif($validated['plastikSumma']!=0){
            $Price = $validated['plastikSumma'];
            #echo "Faqat Plastik"; Plastik tulovlar, user_history va admin_historyga yozilsin
        }else{
            return back()->withInput()->with('error', "To'lov summmasi notig'ri kiritilgan."); 
        }
        if($ChegirmaSumma==null){
            return back()->withInput()->with('error', "To'lov amalga oshirildi."); // Chegirma mavjud emas to'lovlar kiritilgan yuqorida
        }else{
            $guruhga_tulov = $ChegirmaSumma->summa;
            $chegirma_uchun_tulov = $ChegirmaSumma->summa-$ChegirmaSumma->chegirma;
            if($Price==$chegirma_uchun_tulov){
                $guruh_start = Guruh::where('id', $validated['guruh_id'] )->get()->first()->guruh_start;
                $day = $ChegirmaSumma['days'];
                $thisDay = date("Y-m-d");
                $nextDay = date('Y-m-d',strtotime("+".$day." days", strtotime($guruh_start)));
                if($nextDay>=$thisDay){
                    echo "Mavjud Chegirma"; // Oldin shu guruhga chegirma olmagan bo'lsa chegirma qabul qilinsin aks holda qabul qilinmasin.
                }else{
                    return back()->withInput()->with('error', "Guruh uchun chegirma muddati tugagan. Chegirma qabul qilinmadi. To'lovlar kiritildi"); 
                }
            }else{
                return back()->withInput()->with('error', "Chegirma olishi uchun to'lov summasi ".$chegirma_uchun_tulov." so'm bo'lishi kerak. Chegirma qabul qilinmadi. ".$Price." so'm to'lov kiritildi."); 
            }
        }
        dd($ChegirmaSumma);
    }

    public function show(Tolov $tolov){
        
    }

    public function edit(Tolov $tolov){
        //
    }

    public function update(Request $request, Tolov $tolov){
        //
    }

    public function destroy(Tolov $tolov)
    {
        //
    }
}
