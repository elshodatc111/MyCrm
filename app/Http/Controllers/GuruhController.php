<?php

namespace App\Http\Controllers;

use App\Models\Guruh;
use App\Models\Test;
use App\Models\Room;
use App\Models\Setting;
use App\Models\User;
use App\Models\GuruhJadval;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GuruhController extends Controller{
    public function index(){
        return view('guruh.index');
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
        $i=0;
        foreach ($dars_vaqti as $value) {
            $i = $i+1;
            foreach($kunlar as $item){
                $GuruhJadval = GuruhJadval::where('room_id',$Guruh->room_id)
                    ->where('guruh_id',$Guruh->id)
                    ->where('days',$item)
                    ->where('times',$value)->get();
                if(count($GuruhJadval)>0){
                    unset($dars_vaqti[$i]);
                }
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
        return redirect()->route('guruh.index')->with('succes',"Yangi guruh qo'shildi.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Guruh $guruh)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guruh $guruh)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guruh $guruh)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        Guruh::find($id)->delete();
        return redirect()->route('guruh.index')->with('success', 'Bekor qilindi');
    }
}