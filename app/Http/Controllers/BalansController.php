<?php

namespace App\Http\Controllers;
use App\Models\UserHistory;
use Illuminate\Http\Request;

class BalansController extends Controller{
    public function index(){
        $Naqt = UserHistory::where('filial_id',request()->cookie('filial_id'))->get();
        $TulovNaqtFalse = 0; // Tasdiqlanmagan naqt to'lovlar
        $TulovNaqtTrue = 0; // Tasdiqlangan naqt to'lovlar
        $TulovPlastikFalse = 0; // Tasdiqlanmagan Plastik to'lovlar
        $TulovPlastikTrue = 0; // Tasdiqlangan Plastik to'lovlar
        $TulovQaytarildiFalse = 0; // Tasdiqlanmagan Qaytarilgan to'lovlar
        $TulovQaytarildiTrue = 0; // Tasdiqlangan Qaytarilgan to'lovlar
        $About = array();
        foreach ($Naqt as $key => $value) {
            if($value['status']=='TulovNaqt'){
                if($value['type']=='true'){$TulovNaqtTrue = $TulovNaqtTrue + $value->summa;}else{$TulovNaqtFalse = $TulovNaqtFalse + $value->summa;}
            }elseif($value['status']=='TulovPlastik'){
                if($value['type']=='true'){$TulovPlastikTrue = $TulovPlastikTrue + $value->summa;}else{$TulovPlastikFalse = $TulovPlastikFalse + $value->summa;}
            }elseif($value['status']=='TulovQaytarildi'){
                if($value['type']=='true'){$TulovQaytarildiTrue = $TulovQaytarildiTrue + $value->summa;}else{$TulovQaytarildiFalse = $TulovQaytarildiFalse + $value->summa;}
            }
        }
        $About['NaqtFalse'] = number_format(($TulovNaqtFalse), 0, '.', ' ');
        $About['PlastikFalse'] = number_format(($TulovPlastikFalse), 0, '.', ' ');
        $About['QaytarildiFalse'] = number_format(($TulovQaytarildiFalse*(-1)), 0, '.', ' ');

        #dd($About);
        return view('balans.index');
    }
}
