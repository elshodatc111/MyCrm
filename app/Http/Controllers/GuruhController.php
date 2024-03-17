<?php

namespace App\Http\Controllers;

use App\Models\Guruh;
use App\Models\Test;
use App\Models\Tolov;
use App\Models\Room;
use App\Models\Setting;
use App\Models\Eslatma;
use App\Models\GuruhUser;
use App\Models\UserHistory;
use App\Models\User;
use App\Models\GuruhJadval;
use App\Models\StudenHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class GuruhController extends Controller{
    public function index(){
        $endDay = date('Y-m-d',strtotime("-10 days", strtotime(date("Y-m-d"))));
        $Guruh = Guruh::where('guruh_end','>=',$endDay)->orderby('guruh_start','DESC')
        ->where('filial', request()->cookie('filial_id'))->get();
        
        $i=1;
        $items = array();
        foreach ($Guruh as $key=>  $value) {
            $Guruhlar = array();
            $Guruhlar['id'] = $value['id'];
            $Guruhlar['guruh_name'] = $value['guruh_name'];
            $Guruhlar['start'] = $value['guruh_start'];
            $Guruhlar['end'] = $value['guruh_end'];
            $GuruhUser = GuruhUser::where('guruh_id',$value['id'])->where('status','true')->get();

            $Guruhlar['student'] = count($GuruhUser);
            $Guruhlar['summa'] = number_format(($value['guruh_price']), 0, '.', ' ');
            if($value['guruh_start']>date('Y-m-d')){
                $Guruhlar['status'] = "new";
            }else if(date('Y-m-d')>=$value['guruh_start'] AND date('Y-m-d')<=$value['guruh_end']){
                $Guruhlar['status'] = "activ";
            }else{
                $Guruhlar['status'] = "end";
            }
            $items[$i] = $Guruhlar;
            $i++;
        }
        #dd($items);
        return view('guruh.index',compact('items'));

        
    }

    public function indexNew(){
        return view('guruh.index_new');
    }

    public function indexActiv(){
        return view('guruh.index_activ');
    }
    
    public function create(){
        $Test = Test::where('status','true')->get();
        $Room = Room::where('status','true')->where('filial_id',request()->cookie('filial_id'))->get();
        $Setting = Setting::where('filial_id',request()->cookie('filial_id'))->get();
        $Techer = User::where('filial',request()->cookie('filial_id'))->where('type','Techer')->where('status','true')->get();
        return view('guruh.create', compact('Test','Room','Setting','Techer'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            "guruh_name" => ['required'],
            "test_id" => ['required'],
            "room_id" => ['required'],
            "guruh_start" => ['required'],
            "guruh_juft_toq" => ['required'],
            "guruh_price" => ['required'],
            "techer_id" => ['required'],
            "techer_tulov" => ['required'],
            "techer_bonus" => ['required']
        ]);
        $Setting = Setting::where('id',$request->guruh_price)->get()->first();
        $validated['guruh_price'] = $Setting->summa;
        $validated['guruh_chegirma'] = $Setting->chegirma;
        $validated['admin_chegirma'] = $Setting->admin_chegirma;
        $validated['guruh_chegirma_day'] = $Setting->days;
        $validated['admin_id'] = Auth::User()->id;
        $validated['guruh_dars_vaqt'] = "NULL";
        $validated['guruh_end'] = "NULL";
        $validated['status'] = "false";
        $validated['techer_tulov'] = str_replace(",","",$request->techer_tulov);
        $validated['techer_bonus'] = str_replace(",","",$request->techer_bonus);
        $validated['filial'] = request()->cookie('filial_id');
        if($request->guruh_start>=date("Y-m-d")){
            $Guruh = Guruh::where('filial',$validated['filial'])
            ->where('test_id',$validated['test_id'])
            ->where('room_id',$validated['room_id'])
            ->where('guruh_start',$validated['guruh_start'])
            ->where('guruh_juft_toq',$validated['guruh_juft_toq'])
            ->where('techer_id',$validated['techer_id'])
            ->where('status',$validated['status'])
            ->where('techer_tulov',$validated['techer_tulov'])
            ->where('filial',$validated['filial'])->get()->first();
            if(empty($Guruh)){
                $Create = Guruh::create($validated);
                $id = $Create->id;
            }else{
                $id = $Guruh->id;
            }
            return redirect()->route('create2', $id);
        }else{
            return back()->withInput()->with('error', "Yangi guruhni o'tgan sana bilan ochib bo'lmaydi.");
        }
    }

    public function toqKunlar($startDate, $endDate) {
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);
        $i = 1;
        $dates = array();
        while ($startTimestamp <= $endTimestamp) {
            $currentDayOfWeek = date('N', $startTimestamp);
            if (in_array($currentDayOfWeek, [1, 3, 5])) { // Monday, Wednesday, Friday
                if($i==14){break;}
                $dates[] = date('Y-m-d', $startTimestamp);
                $i = $i+1;
            }
            $startTimestamp = strtotime('+1 day', $startTimestamp);
        }
        return $dates;
    }

    public function juftKunlar($startDate, $endDate) {
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);
        $i = 1;
        $dates = array();
        while ($startTimestamp <= $endTimestamp) {
            $currentDayOfWeek = date('N', $startTimestamp);
            if (in_array($currentDayOfWeek, [2, 4, 6])) { // Monday, Wednesday, Friday
                if($i==14){break;}
                $dates[] = date('Y-m-d', $startTimestamp);
                $i = $i+1;
            }
            $startTimestamp = strtotime('+1 day', $startTimestamp);
        }
        return $dates;
    }

    public function boshSoatlar($dars_vaqti){
        $Mavjud_vaqtlar = array();
        foreach($dars_vaqti as $teme){
            switch ($teme) {
                case 1:
                    $Mavjud_vaqtlar['1']['text'] = '08:00-09:30';
                    $Mavjud_vaqtlar['1']['id'] = 1;
                    break;
                case 2:
                    $Mavjud_vaqtlar['2']['text'] = '09:30-11:00';
                    $Mavjud_vaqtlar['2']['id'] = 2;
                    break;
                case 3:
                    $Mavjud_vaqtlar['3']['text'] = '11:00-12:30';
                    $Mavjud_vaqtlar['3']['id'] = 3;
                break;
                case 4:
                    $Mavjud_vaqtlar['4']['text'] = '12:30-14:00';
                    $Mavjud_vaqtlar['4']['id'] = 4;
                    break;
                case 5:
                    $Mavjud_vaqtlar['5']['text'] = '14:00-15:30';
                    $Mavjud_vaqtlar['5']['id'] = 5;
                    break;
                case 6:
                    $Mavjud_vaqtlar['6']['text'] = '15:30-17:00';
                    $Mavjud_vaqtlar['6']['id'] = 6;
                    break;
                case 7:
                    $Mavjud_vaqtlar['7']['text'] = '17:00-18:30';
                    $Mavjud_vaqtlar['7']['id'] = 7;
                    break;
                case 8:
                    $Mavjud_vaqtlar['8']['text'] = '18:30-20:00';
                    $Mavjud_vaqtlar['8']['id'] = 8;
                    break;
                case 9:
                    $Mavjud_vaqtlar['9']['text'] = '20:00-21:30';
                    $Mavjud_vaqtlar['9']['id'] = 9;
                    break;
            }
        }
        return $Mavjud_vaqtlar;
    }

    public function create2($id){
        $Guruh = Guruh::find($id);
        $start = $Guruh->guruh_start;
        $nextDay = date('Y-m-d',strtotime("+40 days", strtotime($start)));
        if($Guruh->guruh_juft_toq == 'juft'){
            $kunlar = $this->juftKunlar($start,$nextDay);
        }else{
            $kunlar = $this->toqKunlar($start,$nextDay);
        }
        $guruh_end = $kunlar[12];
        $dars_vaqti = array(1,2,3,4,5,6,7,8,9);
        $room_id = $Guruh->room_id;
        foreach ($dars_vaqti as $value) {
            $K = 0;
            foreach($kunlar as $item){
                $GuruhJadval = GuruhJadval::where('room_id',$room_id)
                ->where('days',$item)
                ->where('times',$value)->get();
                if(count($GuruhJadval)>0){
                    $K++;
                }
            }
            if($K>0){
                unset($dars_vaqti[$value-1]);
            }
        }
        $boshSoatlar = $this->boshSoatlar($dars_vaqti);
        $Testlar = Test::where('id',$Guruh->test_id)->get()->first()->test_name;
        $Room = Room::where('id',$Guruh->room_id)->get()->first()->room_name;
        $Techer = User::where('id',$Guruh->techer_id)->get()->first()->name;
        #dd($Testlar);
        $Javob = array();
        $Javob['guruh'] = $Guruh;
        $Javob['kunlar'] = $kunlar;
        $Javob['clock'] = $boshSoatlar;
        $Javob['guruh_end'] = $guruh_end;
        $Javob['Testlar'] = $Testlar;
        $Javob['Room'] = $Room;
        $Javob['Techer'] = $Techer;
        #dd($Javob);
        return view('guruh.create2',compact('Javob'));
    }
    public function clock($cloc_id){
        switch ($cloc_id) {
            case 1:
                return '08:00-09:30';
                break;
            case 2:
                return '09:30-11:00';
                break;
            case 3:
                return '11:00-12:30';
            break;
            case 4:
                return '12:30-14:00';
                break;
            case 5:
                return '14:00-15:30';
                break;
            case 6:
                return '15:30-17:00';
                break;
            case 7:
                return '17:00-18:30';
                break;
            case 8:
                return '18:30-20:00';
                break;
            case 9:
                return '20:00-21:30';
                break;
        }
    }
    public function store2(Request $request){
        $Guruh = Guruh::where('id',$request->id)->get()->first();
        $validated = $request->validate([
            "status" => ['required'],
            "guruh_end" => ['required']
        ]);
        $validated['guruh_dars_vaqt'] = $this->clock($request->guruh_dars_vaqt);
        $Guruh->update($validated);
        $start = $Guruh->guruh_start;
        $nextDay = date('Y-m-d',strtotime("+40 days", strtotime($start)));
        if($Guruh->guruh_juft_toq == 'juft'){
            $kunlar = $this->juftKunlar($start,$nextDay);
        }else{
            $kunlar = $this->toqKunlar($start,$nextDay);
        }
        foreach ($kunlar as $value) {
            $Kunlar = new GuruhJadval();
            $Kunlar->filial_id = $Guruh->filial;
            $Kunlar->room_id = $Guruh->room_id;
            $Kunlar->guruh_id = $Guruh->id;
            $Kunlar->days = $value;
            $Kunlar->times = $request->guruh_dars_vaqt;
            $Kunlar->save();
        }
        return redirect()->route('guruh.index')->with('success',"Yangi guruh qo'shildi.");
    }

    public function show($id){
        $Guruhlar = Guruh::where('id',$id)->get()->first();
        if(empty($Guruhlar)){
            return back()->withInput();
        }
        if($Guruhlar['status']==false){
            return back()->withInput();
        }   
        $guruh=array();
        $guruh['guruh_price'] = number_format(($Guruhlar->guruh_price), 0, '.', ' ');
        $guruh['guruh_price2'] = $Guruhlar->guruh_price;
        $guruh['guruh_name'] = $Guruhlar->guruh_name;
        $guruh['techer_bonus'] = number_format(($Guruhlar->techer_bonus), 0, '.', ' ');
        $guruh['techer_tulov'] = number_format(($Guruhlar->techer_tulov), 0, '.', ' ');
        $guruh['created_at'] = $Guruhlar->created_at;
        $guruh['updated_at'] = $Guruhlar->updated_at;
        $guruh['guruh_dars_vaqt'] = $Guruhlar->guruh_dars_vaqt;
        $guruh['guruh_start'] = $Guruhlar->guruh_start;
        $guruh['guruh_end'] = $Guruhlar->guruh_end;
        $guruh['id'] = $id;
        $GuruhJadval = GuruhJadval::where('guruh_id',$id)->get();
        $Jadval = array();
        foreach ($GuruhJadval as $key => $value){
            $Jadval[$key] = $value->days;
        }
        $guruh['jadval'] = $Jadval;
        if($guruh['guruh_start']>=date('Y-m-d') AND $guruh['guruh_start']<=date('Y-m-d')){$guruh['status'] = "Aktiv guruh";}elseif($guruh['guruh_start']>date('Y-m-d')){$guruh['status'] = "Yangi guruh";}else{$guruh['status'] = "Yakunlangan";}
        $UserAdmin = User::where('id',$Guruhlar->admin_id);
        $guruh['admin'] = $UserAdmin->get()->first()->email;
        $UserTecher = User::where('id',$Guruhlar->techer_id);
        $guruh['techer'] = $UserTecher->get()->first()->email;
        $Room = Room::where('id',$Guruhlar->room_id);
        $guruh['room'] = $Room->get()->first()->room_name;
        $AktivUser = GuruhUser::where('guruh_id',$id)->where('status','true')->get();
        $guruh['activ_user'] = count($AktivUser);
        $NeAktivUser = GuruhUser::where('guruh_id',$id)->where('status','false')->get();
        $guruh['nd_activ_user'] = count($NeAktivUser);

        $AUser = GuruhUser::where('guruh_id',$id)
            ->join('users', 'users.id', 'guruh_users.user_id')
            ->where('guruh_users.status','true')
            ->select('users.name','users.id','guruh_users.start_data',
                'guruh_users.start_commit','guruh_users.start_meneger')
            ->get();
        $AktivStudent = array();
        foreach ($AUser as $key => $value) {
            $Meneger = User::where('id',$value->start_meneger)->get()->first()->email;
            $AktivStudent[$key]['student_id'] = $AUser[$key]->id;
            $AktivStudent[$key]['student_name'] = $AUser[$key]->name;
            $AktivStudent[$key]['start_data'] = $AUser[$key]->start_data;
            $AktivStudent[$key]['start_commit'] = $AUser[$key]->start_commit;
            $AktivStudent[$key]['meneger_email'] = $Meneger;
            $AktivStudent[$key]['student_balans'] = number_format(1000, 0, '.', ' ');
        }
        $DUser = GuruhUser::where('guruh_id',$id)
            ->join('users', 'users.id', 'guruh_users.user_id')
            ->where('guruh_users.status','false')
            ->select('users.name','users.id','guruh_users.start_data',
                'guruh_users.start_commit','guruh_users.end_meneger','guruh_users.end_commit','guruh_users.end_data','guruh_users.start_meneger')
            ->get();
        $EndStudent = array();
        foreach ($DUser as $key => $value) {
            $Meneger = User::where('id',$value->start_meneger)->get()->first()->email;
            $EndMeneger = User::where('id',$value->end_meneger)->get()->first()->email;
            $EndStudent[$key]['student_id'] = $DUser[$key]->id;
            $EndStudent[$key]['student_name'] = $DUser[$key]->name;
            $EndStudent[$key]['start_data'] = $DUser[$key]->start_data;
            $EndStudent[$key]['start_commit'] = $DUser[$key]->start_commit;
            $EndStudent[$key]['end_data'] = $DUser[$key]->end_data;
            $EndStudent[$key]['end_commit'] = $DUser[$key]->end_commit;
            $EndStudent[$key]['meneger_email'] = $Meneger;
            $EndStudent[$key]['meneger_end_email'] = $EndMeneger;
            $Jarima = StudenHistory::where('student_id',$DUser[$key]->id)->where('guruh_id',$id)->where('status','GuruhDeleteJarima')->get();
            $JarimaSumma = 0;
            foreach ($Jarima as $value) {
                $JarimaSumma = $JarimaSumma + $value['summa'];
            }
            $EndStudent[$key]['jarima'] = number_format($JarimaSumma, 0, '.', ' ');
        }

        
        $eslatma = Eslatma::where('eslatmas.type','guruh')
        ->join('users','users.id','eslatmas.admin_id')
        ->where('eslatmas.user_guruh_id',$id)
        ->select('users.email','eslatmas.text','eslatmas.created_at','eslatmas.status')
        ->orderBy('eslatmas.id', 'DESC')->get();
        #dd($eslatma[0]['name']);

        $Kassa = UserHistory::where('status','TulovNaqt')->where('type','false')->get();
        $NaqtKass = 0;
        foreach ($Kassa as $key => $value) {
            $NaqtKass = $NaqtKass+$value->summa;
        }
        $NaqtKass = number_format($NaqtKass, 0, '.', ' ');

        return view('guruh.show', compact('guruh','AktivStudent','EndStudent','NaqtKass','eslatma'));
    }
    public function tulovQaytarish(Request $request){
        $guruh_id = $request->guruh_id;
        $NaqtKass = str_replace(" ","",$request->NaqtKass);
        $user_id = $request->user_id;
        $summa = str_replace(",","",$request->summa);
        $Izoh = $request->Izoh;
        if($summa>$NaqtKass){
            return back()->withInput()->with('success',"Kassada mablag' yetarli emas.");
        }
        $Tulov = new Tolov();
        $Tulov->filial_id = request()->cookie('filial_id');
        $Tulov->user_id = $user_id;
        $Tulov->guruh_id = $guruh_id;
        $Tulov->summa = -$summa;
        $Tulov->type = "Qaytarildi";
        $Tulov->comment = $Izoh;
        $Tulov->admin_id = Auth::user()->id;
        $Tulov->chegirma_id = 0;
        $Tulov->save();
        $StudenHistory = new StudenHistory();
        $StudenHistory->filial_id = request()->cookie('filial_id');
        $StudenHistory->student_id	 = $user_id;
        $StudenHistory->status =  "Tulov";
        $StudenHistory->summa = -$summa;
        $StudenHistory->type = "Qaytarildi";
        $StudenHistory->admin_id = Auth::user()->id;
        $StudenHistory->guruh_id = $guruh_id;
        $StudenHistory->tulov_id = $Tulov->id;
        $StudenHistory->save();
        $UserHistory = new UserHistory();
        $UserHistory->filial_id = request()->cookie('filial_id');
        $UserHistory->admin_id = Auth::user()->id;
        $UserHistory->status = 'TulovQaytarildi';
        $UserHistory->summa = -$summa;
        $UserHistory->type = 'false';
        $UserHistory->student_id = $user_id;
        $UserHistory->izoh = $Izoh;
        $UserHistory->tulov_id = $Tulov->id;
        $UserHistory->save();
        return back()->withInput()->with('success',"To'lov qaytarildi. Tasdiqlanishi kutilmoqda.");
    }

    public function edit(Guruh $guruh){
        $Test = Test::where('status','true')->get();
        $Room = Room::where('status','true')->where('filial_id',request()->cookie('filial_id'))->get();
        $Setting = Setting::where('filial_id',request()->cookie('filial_id'))->get();
        $Techer = User::where('filial',request()->cookie('filial_id'))->where('type','Techer')->where('status','true')->get();
        return view('guruh.edit',compact('guruh','Test','Room','Setting','Techer'));
    }

    public function update(Request $request, Guruh $guruh){
        $validated = $request->validate([
            "guruh_name" => ['required'],
            "test_id" => ['required'],
            "guruh_price" => ['required'],
            "techer_id" => ['required'],
            "techer_tulov" => ['required'],
            "techer_bonus" => ['required'],
        ]);
        $Setting = Setting::find($request->guruh_price);
        $validated['guruh_price'] = $Setting->summa;
        $validated['guruh_chegirma'] = $Setting->chegirma;
        $validated['guruh_chegirma_day'] = $Setting->days;
        $validated['admin_chegirma'] = $Setting->admin_chegirma;
        $guruh->update($validated);
        return redirect()->route('guruh.index')->with('success', 'Guruh yanfilandi.');
    }

    public function distroy2($id){
        dd($id." Guruh tarixi mavjud bo'lmasa delete aks holda status=false bo'lsin");
    }
    public function destroy($id){
        Guruh::find($id)->delete();
        return redirect()->route('guruh.index')->with('success', 'Bekor qilindi');
    }
}
