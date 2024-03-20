<?php

namespace App\Http\Controllers;
use App\Models\Tolov;
use App\Models\Guruh;
use App\Models\User;
use App\Models\UserHistory;
use App\Models\StudenHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;
use Illuminate\Http\Request;

class TolovController extends Controller{
    public function index(){
        //
    }

    public function create(){
        //
    }
    
    public function SendMessege($phone, $text){
        $eskiz = new Eskiz(config('api.eskiz_email'),config('api.eskiz_password'));
        $eskiz->requestAuthLogin();
        $from='4546';
        $mobile_phone = "+998".$phone;
        $message = $text;
        $user_sms_id = 1;
        $callback_url = '';
        $singleSmsType = new SmsSingleSmsType(from: $from,message: $message,mobile_phone: $mobile_phone,user_sms_id:$user_sms_id,callback_url:$callback_url);
        $result = $eskiz->requestSmsSend($singleSmsType);
        if($result->getResponse()->isSuccess == true){
            return true;
        }else{
            return false;
        }
    }
    
    ### Talaba Tulovlarini qabul qilish CRM orqali ###
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
        $JamiTulovSummasi = $validated['naqtSumma'] + $validated['plastikSumma'];
        $name = User::find($request->user_id)->name;
        $SMS = $name." ATKO koreys tili markazi kurslar uchun ";
        $phone = str_replace(" ","",User::find($request->user_id)->phone);
        if($validated['naqtSumma'] != 0){ ### Naqt Tulov kassasi ###
            $NaqtTulov = new Tolov();
            $NaqtTulov->filial_id = intval(request()->cookie('filial_id'));
            $NaqtTulov->user_id =  $validated['user_id'];
            $NaqtTulov->guruh_id =  $validated['guruh_id'];
            $NaqtTulov->summa = $validated['naqtSumma'];
            $NaqtTulov->type = "Naqt";
            $NaqtTulov->comment = $validated['commit'];
            $NaqtTulov->admin_id = Auth::User()->id;
            $NaqtTulov->chegirma_id = 0;
            $NaqtTulov->save();
            $Tulov_id = $NaqtTulov->id;
            $SMS = $SMS."Naqt: ".$validated['naqtSumma']." so'm ";
            $UserHistoryNaqt = new UserHistory();
            $UserHistoryNaqt->filial_id = intval(request()->cookie('filial_id'));
            $UserHistoryNaqt->admin_id = Auth::User()->id;
            $UserHistoryNaqt->status = "TulovNaqt";
            $UserHistoryNaqt->summa = $validated['naqtSumma'];
            $UserHistoryNaqt->type = "false";
            $UserHistoryNaqt->student_id = $validated['user_id'];
            $UserHistoryNaqt->izoh = $validated['commit'];
            $UserHistoryNaqt->tulov_id = $Tulov_id;
            $UserHistoryNaqt->save();

            $StudentHistory = new StudenHistory();
            $StudentHistory->filial_id = intval(request()->cookie('filial_id'));
            $StudentHistory->student_id = $validated['user_id'];
            $StudentHistory->status = "Tulov";
            $StudentHistory->summa = $validated['naqtSumma'];
            $StudentHistory->type = "Naqt";
            $StudentHistory->admin_id = Auth::User()->id;
            $StudentHistory->guruh_id = $validated['guruh_id'];
            $StudentHistory->tulov_id = $Tulov_id;
            $StudentHistory->save();
        }
        if($validated['plastikSumma'] != 0){ ### Plastik Tulov Kassasi ###
            $NaqtTulov = new Tolov();
            $NaqtTulov->filial_id = intval(request()->cookie('filial_id'));
            $NaqtTulov->user_id =  $validated['user_id'];
            $NaqtTulov->guruh_id =  $validated['guruh_id'];
            $NaqtTulov->summa = $validated['plastikSumma'];
            $NaqtTulov->type = "Plastik";
            $NaqtTulov->comment = $validated['commit'];
            $NaqtTulov->admin_id = Auth::User()->id;
            $NaqtTulov->chegirma_id = 0;
            $NaqtTulov->save();
            $SMS = $SMS."Plastik: ".$validated['plastikSumma']." so'm ";
            $Tulov_id = $NaqtTulov->id;
            $UserHistoryNaqt = new UserHistory();
            $UserHistoryNaqt->filial_id = intval(request()->cookie('filial_id'));
            $UserHistoryNaqt->admin_id = Auth::User()->id;
            $UserHistoryNaqt->status = "TulovPlastik";
            $UserHistoryNaqt->summa = $validated['plastikSumma'];
            $UserHistoryNaqt->type = "false";
            $UserHistoryNaqt->student_id = $validated['user_id'];
            $UserHistoryNaqt->izoh = $validated['commit'];
            $UserHistoryNaqt->tulov_id = $Tulov_id;
            $UserHistoryNaqt->save();
            $StudentHistory = new StudenHistory();
            $StudentHistory->filial_id = intval(request()->cookie('filial_id'));
            $StudentHistory->student_id = $validated['user_id'];
            $StudentHistory->status = "Tulov";
            $StudentHistory->summa = $validated['plastikSumma'];
            $StudentHistory->type = "Plastik";
            $StudentHistory->admin_id = Auth::User()->id;
            $StudentHistory->guruh_id = $validated['guruh_id'];
            $StudentHistory->tulov_id = $Tulov_id;
            $StudentHistory->save();
        }
        if($JamiTulovSummasi == 0){
            return back()->withInput()->with('error',"To'lov summasi noto'g'ri kiritildi.");
        }
        if($validated['guruh_id'] == 'NULL'){
            $SMS = $SMS."to'ov qabul qilindi. \n".config('api.messege_text');
            $this->SendMessege($phone, $SMS);
            return back()->withInput()->with('success',"To'lov qabul qilindi.");
        }else{
            $Guruh = Guruh::find(intval($validated['guruh_id']));
            $guruh_price = $Guruh->guruh_price;
            $guruh_chegirma = $Guruh->guruh_chegirma;
            $guruh_chegirma_day = $Guruh->guruh_chegirma_day;
            $guruh_chegirma_tulov = $guruh_price-$guruh_chegirma;
            $Guruh_Statrt = $Guruh->guruh_start;
            $Chegirma_Muddat = date('Y-m-d', strtotime("+".$guruh_chegirma_day." day", strtotime($Guruh_Statrt)));
            if($JamiTulovSummasi == $guruh_chegirma_tulov){
                if($Chegirma_Muddat>=date("Y-m-d")){
                    $CheckTulov = Tolov::where('user_id',$validated['user_id'])
                        ->where('guruh_id',$validated['guruh_id'])
                        ->where('type',"Chegirma")
                        ->where('summa',$guruh_chegirma)
                        ->get();
                    if(count($CheckTulov)>=1){
                        $SMS = $SMS." to'ov qabul qilindi.\n".config('api.messege_text');
                        $this->SendMessege($phone, $SMS);
                        return back()->withInput()->with('success',"To'lov qabul qilindi. Talaba tanlangan guruh uchun oldin chegirma olgan.");
                    }else{
                        $NaqtTulov = new Tolov();
                        $NaqtTulov->filial_id = intval(request()->cookie('filial_id'));
                        $NaqtTulov->user_id =  $validated['user_id'];
                        $NaqtTulov->guruh_id =  $validated['guruh_id'];
                        $NaqtTulov->summa = $guruh_chegirma;
                        $NaqtTulov->type = "Chegirma";
                        $NaqtTulov->comment = $validated['commit'];
                        $NaqtTulov->admin_id = Auth::User()->id;
                        $NaqtTulov->chegirma_id = 0;
                        $NaqtTulov->save();
                        $SMS = $SMS."Chegirma: ".$guruh_chegirma." so'm ";
                        $Tulov_id = $NaqtTulov->id;
                        $UserHistoryNaqt = new UserHistory();
                        $UserHistoryNaqt->filial_id = intval(request()->cookie('filial_id'));
                        $UserHistoryNaqt->admin_id = Auth::User()->id;
                        $UserHistoryNaqt->status = "TulovChegirma";
                        $UserHistoryNaqt->summa = $guruh_chegirma;
                        $UserHistoryNaqt->type = "true";
                        $UserHistoryNaqt->student_id = $validated['user_id'];
                        $UserHistoryNaqt->izoh = $validated['commit'];
                        $UserHistoryNaqt->tulov_id = $Tulov_id;
                        $UserHistoryNaqt->save();
                        $StudentHistory = new StudenHistory();
                        $StudentHistory->filial_id = intval(request()->cookie('filial_id'));
                        $StudentHistory->student_id = $validated['user_id'];
                        $StudentHistory->status = "Tulov";
                        $StudentHistory->summa = $guruh_chegirma;
                        $StudentHistory->type = "Chegirma";
                        $StudentHistory->admin_id = Auth::User()->id;
                        $StudentHistory->guruh_id = $validated['guruh_id'];
                        $StudentHistory->tulov_id = $Tulov_id;
                        $StudentHistory->save();
                        $SMS = $SMS."to'ov qabul qilindi. \n".config('api.messege_text');
                        $this->SendMessege($phone, $SMS);
                        return back()->withInput()->with('success',"To'lov qabul qilindi. ".$guruh_chegirma." so'm chegirma oldi.");
                    }
                }else{
                    return back()->withInput()->with('success',"Chegirma muddati tugagan.");
                }
            }else{  
                $SMS = $SMS."to'ov qabul qilindi. \n".config('api.messege_text');
                $this->SendMessege($phone, $SMS);
                return back()->withInput()->with('success',"To'lov qabul qilindi.");
            }
            
            dd($Guruh);
            
        }


        #dd($validated);
        #return back()->withInput();
    }

    public function show(Tolov $tolov){
        
    }

    public function edit(Tolov $tolov){
        //
    }

    public function update(Request $request, Tolov $tolov){
        //
    }
    
    public function destroy(string $tolov){
        
    }
}
