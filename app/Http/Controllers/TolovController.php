<?php

namespace App\Http\Controllers;
use App\Models\Tolov;
use App\Models\Guruh;
use App\Models\UserHistory;
use App\Models\StudenHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use Illuminate\Http\Request;

class TolovController extends Controller{
    public function index(){
        //
    }

    public function create(){
        //
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
        $ChegirmaSumma = Guruh::where('guruhs.id',$validated['guruh_id'])
            ->where('settings.filial_id',request()->cookie('filial_id'))
            ->join('settings','guruhs.guruh_price','settings.summa')
            ->select('settings.days','settings.summa','settings.chegirma')->get()->first();
        $Price = 0;
        if($validated['naqtSumma']!=0 AND $validated['plastikSumma']!=0){ ### Naqt va Pastik kassa
            $Price = $validated['naqtSumma']+$validated['plastikSumma'];
            
            $TulovNaqt = new Tolov();
            $TulovNaqt->filial_id=intval(request()->cookie('filial_id'));
            $TulovNaqt->user_id=$validated['user_id'];
            $TulovNaqt->guruh_id=$validated['guruh_id'];
            $TulovNaqt->summa=$validated['naqtSumma'];
            $TulovNaqt->type='Naqt';
            $TulovNaqt->comment=$validated['commit'];
            $TulovNaqt->admin_id=Auth::user()->id;
            $TulovNaqt->chegirma_id='NULL';
            $TulovNaqt->save();

            $UserHistoryNaqt = new UserHistory();
            $UserHistoryNaqt->filial_id=intval(request()->cookie('filial_id'));
            $UserHistoryNaqt->admin_id=Auth::user()->id;
            $UserHistoryNaqt->status='Tulov';
            $UserHistoryNaqt->summa=$validated['naqtSumma'];
            $UserHistoryNaqt->type='Naqt';
            $UserHistoryNaqt->student_id=$validated['user_id'];
            $UserHistoryNaqt->izoh=$validated['commit'];
            $UserHistoryNaqt->save();

            $StudenHisNaqt = new StudenHistory();
            $StudenHisNaqt->filial_id=intval(request()->cookie('filial_id'));
            $StudenHisNaqt->student_id=$validated['user_id'];
            $StudenHisNaqt->status='Naqt';
            $StudenHisNaqt->summa=$validated['naqtSumma'];
            $StudenHisNaqt->type=0;
            $StudenHisNaqt->admin_id=Auth::user()->id;
            $StudenHisNaqt->guruh_id=$validated['guruh_id'];
            $StudenHisNaqt->save();
            
            $TulovPlastik = new Tolov();
            $TulovPlastik->filial_id=intval(request()->cookie('filial_id'));
            $TulovPlastik->user_id=$validated['user_id'];
            $TulovPlastik->guruh_id=$validated['guruh_id'];
            $TulovPlastik->summa=$validated['plastikSumma'];
            $TulovPlastik->type='Plastik';
            $TulovPlastik->comment=$validated['commit'];
            $TulovPlastik->admin_id=Auth::user()->id;
            $TulovPlastik->chegirma_id='NULL';
            $TulovPlastik->save();

            $StudenHisNaqt = new StudenHistory();
            $StudenHisNaqt->filial_id=intval(request()->cookie('filial_id'));
            $StudenHisNaqt->student_id=$validated['user_id'];
            $StudenHisNaqt->status='Plastik';
            $StudenHisNaqt->type=0;
            $StudenHisNaqt->summa=$validated['plastikSumma'];
            $StudenHisNaqt->admin_id=Auth::user()->id;
            $StudenHisNaqt->guruh_id=$validated['guruh_id'];
            $StudenHisNaqt->save();

            $UserHistoryPlastik = new UserHistory();
            $UserHistoryPlastik->filial_id=intval(request()->cookie('filial_id'));
            $UserHistoryPlastik->admin_id=Auth::user()->id;
            $UserHistoryPlastik->status='Tulov';
            $UserHistoryPlastik->summa=$validated['plastikSumma'];
            $UserHistoryPlastik->type='Plastik';
            $UserHistoryPlastik->student_id=$validated['user_id'];
            $UserHistoryPlastik->izoh=$validated['commit'];
            $UserHistoryPlastik->save();
        }elseif($validated['naqtSumma']!=0){      #### Faqat Naqt tulov kassasi
            $Price = $validated['naqtSumma'];
            $TulovNaqt = new Tolov();
            $TulovNaqt->filial_id=intval(request()->cookie('filial_id'));
            $TulovNaqt->user_id=$validated['user_id'];
            $TulovNaqt->guruh_id=$validated['guruh_id'];
            $TulovNaqt->summa=$validated['naqtSumma'];
            $TulovNaqt->type='Naqt';
            $TulovNaqt->comment=$validated['commit'];
            $TulovNaqt->admin_id=Auth::user()->id;
            $TulovNaqt->chegirma_id='NULL';
            $TulovNaqt->save();

            $UserHistoryNaqt = new UserHistory();
            $UserHistoryNaqt->filial_id=intval(request()->cookie('filial_id'));
            $UserHistoryNaqt->admin_id=Auth::user()->id;
            $UserHistoryNaqt->status='Tulov';
            $UserHistoryNaqt->summa=$validated['naqtSumma'];
            $UserHistoryNaqt->type='Naqt';
            $UserHistoryNaqt->student_id=$validated['user_id'];
            $UserHistoryNaqt->izoh=$validated['commit'];
            $UserHistoryNaqt->save();

            $StudenHisNaqt = new StudenHistory();
            $StudenHisNaqt->filial_id=intval(request()->cookie('filial_id'));
            $StudenHisNaqt->student_id=$validated['user_id'];
            $StudenHisNaqt->status='Naqt';
            $StudenHisNaqt->summa=$validated['naqtSumma'];
            $StudenHisNaqt->type=0;
            $StudenHisNaqt->admin_id=Auth::user()->id;
            $StudenHisNaqt->guruh_id=$validated['guruh_id'];
            $StudenHisNaqt->save();
        }elseif($validated['plastikSumma']!=0){   #### Plastik Tulov kassasi
            $Price = $validated['plastikSumma'];
            $TulovPlastik = new Tolov();
            $TulovPlastik->filial_id=intval(request()->cookie('filial_id'));
            $TulovPlastik->user_id=$validated['user_id'];
            $TulovPlastik->guruh_id=$validated['guruh_id'];
            $TulovPlastik->summa=$validated['plastikSumma'];
            $TulovPlastik->type='Plastik';
            $TulovPlastik->comment=$validated['commit'];
            $TulovPlastik->admin_id=Auth::user()->id;
            $TulovPlastik->chegirma_id='NULL';
            $TulovPlastik->save();

            $StudenHisNaqt = new StudenHistory();
            $StudenHisNaqt->filial_id=intval(request()->cookie('filial_id'));
            $StudenHisNaqt->student_id=$validated['user_id'];
            $StudenHisNaqt->status='Plastik';
            $StudenHisNaqt->type=0;
            $StudenHisNaqt->summa=$validated['plastikSumma'];
            $StudenHisNaqt->admin_id=Auth::user()->id;
            $StudenHisNaqt->guruh_id=$validated['guruh_id'];
            $StudenHisNaqt->save();

            $UserHistoryPlastik = new UserHistory();
            $UserHistoryPlastik->filial_id=intval(request()->cookie('filial_id'));
            $UserHistoryPlastik->admin_id=Auth::user()->id;
            $UserHistoryPlastik->status='Tulov';
            $UserHistoryPlastik->summa=$validated['plastikSumma'];
            $UserHistoryPlastik->type='Plastik';
            $UserHistoryPlastik->student_id=$validated['user_id'];
            $UserHistoryPlastik->izoh=$validated['commit'];
            $UserHistoryPlastik->save();
        }else{ ### To'lov summalari 0 bo'lib kelsa ###
            return back()->withInput()->with('error', "To'lovda xatolik sodir bo'ldi. Qaytadan urinib ko'ring."); 
        }
        if($ChegirmaSumma==null){  ### Guruh tanlanmaganda faqat to'lovlarni qabul qiladi Chegirma olinmaydi ###
            return back()->withInput()->with('error', "To'lov amalga oshirildi."); // Chegirma mavjud emas to'lovlar kiritilgan yuqorida
        }else{ ### Chegirma Mavjud Bo'sa Tekshirilmoqda ###
            $guruhga_tulov = $ChegirmaSumma->summa;  ### Guruh Naqrxi  ###
            $chegirma_uchun_tulov = $guruhga_tulov-$ChegirmaSumma->chegirma; ### CHegirma olish uchun Tulov Summasi ###
            $chegirma_summ = $ChegirmaSumma->chegirma;  ### Chegirma summasi  ###
            #dd($chegirma_summ);
            if($Price==$chegirma_uchun_tulov){ ### Chegirma uchun to'lov mosligi tekshirilmoqda  ####
                $guruh_start = Guruh::where('id', $validated['guruh_id'] )->get()->first()->guruh_start;
                $day = $ChegirmaSumma['days'];
                $thisDay = date("Y-m-d");
                $nextDay = date('Y-m-d',strtotime("+".$day." days", strtotime($guruh_start)));
                if($nextDay>=$thisDay){  ### Chegirma qabul qilinishi mumkun  ###
                    $ChegirmaMavjud = Tolov::where('user_id',$validated['user_id'])
                    ->where('guruh_id',$validated['guruh_id'] )
                    ->where('summa',$chegirma_summ)
                    ->get();
                    if(count($ChegirmaMavjud)==0){  ### Chegirma mavjud bo'lsa qabul qilinadi ###
                        $TulovPlastik = new Tolov();
                        $TulovPlastik->filial_id=intval(request()->cookie('filial_id'));
                        $TulovPlastik->user_id=$validated['user_id'];
                        $TulovPlastik->guruh_id=$validated['guruh_id'];
                        $TulovPlastik->summa=$chegirma_summ;
                        $TulovPlastik->type='Chegirma';
                        $TulovPlastik->comment=$validated['commit'];
                        $TulovPlastik->admin_id=Auth::user()->id;
                        $TulovPlastik->chegirma_id='NULL';
                        $TulovPlastik->save();
                        $StudenHisNaqt = new StudenHistory();
                        $StudenHisNaqt->filial_id=intval(request()->cookie('filial_id'));
                        $StudenHisNaqt->student_id=$validated['user_id'];
                        $StudenHisNaqt->status='Chegirma';
                        $StudenHisNaqt->type=0;
                        $StudenHisNaqt->summa=$chegirma_summ;
                        $StudenHisNaqt->admin_id=Auth::user()->id;
                        $StudenHisNaqt->guruh_id=$validated['guruh_id'];
                        $StudenHisNaqt->save();
                        $UserHistoryPlastik = new UserHistory();
                        $UserHistoryPlastik->filial_id=intval(request()->cookie('filial_id'));
                        $UserHistoryPlastik->admin_id=Auth::user()->id;
                        $UserHistoryPlastik->status='Tulov';
                        $UserHistoryPlastik->summa=$chegirma_summ;
                        $UserHistoryPlastik->type='Chegirma';
                        $UserHistoryPlastik->student_id=$validated['user_id'];
                        $UserHistoryPlastik->izoh=$validated['commit'];
                        $UserHistoryPlastik->save();
                        return back()->withInput()->with('success', "To'lovlar qabul qilindi va talaba ".$chegirma_summ." so'm chegirma qilindi."); 
                    }else{ ### Chegirma oldin qabul qilingan bo'lsa qaytaradi ###
                        return back()->withInput()->with('error', "To'lovlar qabul qilindi. Talab oldin guruhga chegirma olgan."); 
                    }
                }else{ ### Guruh chegirma uchun muddati yakunlangan  ###
                    return back()->withInput()->with('error', "Guruh uchun chegirma muddati tugagan. Chegirma qabul qilinmaydi. To'lovlar kiritildi."); 
                }
            }else{
                return back()->withInput()->with('error', "Chegirma olishi uchun to'lov summasi ".$chegirma_uchun_tulov." so'm bo'lishi kerak. Chegirma qabul qilinmadi. ".$Price." so'm to'lov kiritildi."); 
            }
        }
        return back()->withInput();
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
