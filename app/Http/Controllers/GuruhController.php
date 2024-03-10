<?php

namespace App\Http\Controllers;

use App\Models\Guruh;
use App\Models\Test;
use App\Models\Room;
use App\Models\Setting;
use App\Models\GuruhUser;
use App\Models\User;
use App\Models\GuruhJadval;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GuruhController extends Controller{
    public function index(){
        $endDay = date('Y-m-d',strtotime("-10 days", strtotime(date("Y-m-d"))));
        $Guruh = Guruh::where('status','true')
        ->where('guruh_end','>=',$endDay)->orderby('guruh_start','DESC')
        ->where('filial', request()->cookie('filial_id'))->get();
        
        $i=1;
        $items = array();
        foreach ($Guruh as $value) {
            $Guruhlar = array();
            $Guruhlar['id'] = $value['id'];
            $Guruhlar['guruh_name'] = $value['guruh_name'];
            $Guruhlar['start'] = $value['guruh_start'];
            $Guruhlar['end'] = $value['guruh_end'];
            $Guruhlar['student'] = 0; // GURUHDAGI TALABALAR SONINI QO"YISH KERAK
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
        $Guruh = array();
        $Guruh_about = Guruh::find($id);
        $guruh_techer = User::find($Guruh_about->techer_id)->name;
        $guruh_admin = User::find($Guruh_about->admin_id)->email;
        $guruh_start = $Guruh_about->guruh_start;
        $guruh_end = $Guruh_about->guruh_end;
        $this_data = date('Y-m-d');
        $room_name = Room::find($Guruh_about->room_id)->room_name;
        if($this_data>=$guruh_start AND $this_data<=$guruh_end){
            $guruh_xolati = "Guruh aktiv";
        }elseif($this_data>$guruh_end){
            $guruh_xolati = "Guruh yakunlangan";
        }else{
            $guruh_xolati = "Yangi guruh";
        }
        $GuruhJadval = GuruhJadval::where('guruh_id',$Guruh_about->id)->get();
        $dars_kunlar = array();
        foreach($GuruhJadval as $item){
            array_push($dars_kunlar,$item->days);
        }
        $activ_student = 0;
        $end_student = 0;
        $student = GuruhUser::where('guruh_users.guruh_id',$id)->get();
        foreach($student as $item){
            if($item->status=='true'){
                $activ_student = $activ_student + 1;
            }else{
                $end_student = $end_student + 1;
            }
        }
        #dd($dars_kunlar);
        $Guruh['guruh_about']['id'] = $Guruh_about->id;
        $Guruh['guruh_about']['guruh_name'] = $Guruh_about->guruh_name;
        $Guruh['guruh_about']['guruh_price'] = $Guruh_about->guruh_price;
        $Guruh['guruh_about']['techer_tulov'] = $Guruh_about->techer_tulov;
        $Guruh['guruh_about']['techer_bonus'] = $Guruh_about->techer_bonus;
        $Guruh['guruh_about']['created_at'] = $Guruh_about->created_at;
        $Guruh['guruh_about']['updated_at'] = $Guruh_about->updated_at;
        $Guruh['guruh_about']['guruh_techer'] = $guruh_techer;
        $Guruh['guruh_about']['guruh_admin'] = $guruh_admin;
        $Guruh['guruh_about']['guruh_xolati'] = $guruh_xolati;
        $Guruh['guruh_about']['room_name'] = $room_name;
        $Guruh['guruh_about']['activ_student'] = $activ_student;
        $Guruh['guruh_about']['end_student'] = $end_student;
        $Guruh['guruh_about']['guruh_start'] = $Guruh_about->guruh_start;
        $Guruh['guruh_about']['guruh_end'] = $Guruh_about->guruh_end;
        $Guruh['guruh_about']['guruh_dars_kun'] = $dars_kunlar;
        $Guruh['guruh_about']['guruh_dars_vaqt'] = $Guruh_about->guruh_dars_vaqt;

        #dd($Guruh['guruh_about']['guruh_dars_kun']);
        $GuruhActivUser = GuruhUser::where('guruh_users.guruh_id',$id)
        ->where('guruh_users.status','true')
        ->JOIN('users', 'users.id','guruh_users.user_id')
        ->select('guruh_users.guruh_id','users.id','users.name','guruh_users.start_data','guruh_users.start_commit','guruh_users.start_meneger')
        ->get();
        
        
            foreach ($GuruhActivUser as $key => $value) {
                $Guruh['activTalaba'][$key]['user_id'] = $value->id;
                $Guruh['activTalaba'][$key]['user_name'] = $value->name;
                $Guruh['activTalaba'][$key]['guruh_id'] = $value->guruh_id;
                $Guruh['activTalaba'][$key]['start_data'] = $value->start_data;
                $Guruh['activTalaba'][$key]['start_commit'] = $value->start_commit;
                $Guruh['activTalaba'][$key]['balans'] = 0;   #### Talaba balansini xisoblash kerak
                $MyAdmin = User::where('id', $value->start_meneger)->get()->first();
                $Guruh['activTalaba'][$key]['admin_email'] = $MyAdmin->email;
            }
        
        

        $GuruhEndUser = GuruhUser::where('guruh_users.guruh_id',$id)
        ->where('guruh_users.status','false')
        ->JOIN('users', 'users.id','guruh_users.user_id')
        ->select('guruh_users.guruh_id','users.id','users.name','guruh_users.start_data','guruh_users.start_commit','guruh_users.start_meneger')
        ->get();
        dd(count($GuruhEndUser));
        foreach ($GuruhEndUser as $key => $value) {
            $Guruh['endTalaba'][$key]['user_id'] = $value->id;
            $Guruh['endTalaba'][$key]['user_name'] = $value->name;
            $Guruh['endTalaba'][$key]['guruh_id'] = $value->guruh_id;
            $Guruh['endTalaba'][$key]['start_data'] = $value->start_data;
            $Guruh['endTalaba'][$key]['start_commit'] = $value->start_commit;
            $Guruh['endTalaba'][$key]['end_commit'] = $value->end_commit;
            $Guruh['endTalaba'][$key]['end_data'] = $value->end_data;
            $MyAdmin = User::where('id', $value->start_meneger)->get()->first();
            $Guruh['endTalaba'][$key]['admin_email'] = $MyAdmin->email;
            $MyEndAdmin = User::where('id', $value->end_meneger)->get()->first();
            dd($MyEndAdmin);
            $Guruh['endTalaba'][$key]['end_meneger'] = $MyEndAdmin->email;
            $Guruh['endTalaba'][$key]['jarima'] = 0;  ### Talaba guruhdan chiqazilgandagi jarima summasini
        }
        if(empty($Guruh['endTalaba'])){
            $Guruh['endTalaba'] = 0;
        }
        if(empty($Guruh['activTalaba'])){
            $Guruh['activTalaba'] = 0;
        }
        #dd($Guruh);
        return view('guruh.show', compact('Guruh'));
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
