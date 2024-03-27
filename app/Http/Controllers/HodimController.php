<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Filial;
use App\Models\UserHistory;
use App\Models\IshHaqi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;

class HodimController extends Controller{
    
    public function index(){
        if((!request()->cookie('filial_id')) OR (!request()->cookie('filial_name'))){
            return redirect()->route('setCookie');
        }else{
            $Users = User::where('filial','=',request()->cookie('filial_id'))
                ->join('filials','users.filial','filials.id')
                ->select("users.id","users.name","users.address","users.phone","users.tkun","users.type","users.status","users.email","filials.filial_name")
                ->where('users.status',"=",'true')
                ->where('users.type','!=','user')
                ->where('users.type','!=','techer')->get();
            return view('hodim.home',compact('Users'));
        }
    }

    public function hodimLock(){
        if((!request()->cookie('filial_id')) OR (!request()->cookie('filial_name'))){
            return redirect()->route('setCookie');
        }else{
            $Users = User::where('filial','=',request()->cookie('filial_id'))
                ->join('filials','users.filial','filials.id')
                ->select("users.id","users.name","users.address","users.phone","users.tkun","users.type","users.status","users.email","filials.filial_name")
                ->where('users.status',"=",'false')
                ->where('users.type','!=','user')
                ->where('users.type','!=','techer')->get();
            return view('hodim.home-lock',compact('Users'));
        }
    } 
    public function SendMessege2(Request $request){
        $phone = $request->phone;
        $text = $request->text;
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
            return back()->withInput()->with('success',"SMS xabar yuborildi.");
        }else{
            return back()->withInput()->with('error',"SMS xabar yuborishda xatolik sodir bo'ldi qaytadan urinib ko'tring.");
        }
    }
    public function SendMessege(string $phone, string $text){
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
    public function LockOpen($id){
        $User = User::find($id);
        $User->status = "true";
        $pass = rand(10000000,99999999);
        $User->password = Hash::make($pass);
        $phone = str_replace(" ","",$User->phone);
        $login = $User->email;
        $parol = $pass;
        $text = $User->name." ".request()->cookie('filial_name')." o'quv markaziga ish faoliyatingi qaytadan tiklandi. Shaxsiy kabinetga kirish uchun sizning\nLogin:".$login."\nParol: ".$parol."\n".config('api.messege_text');
        $this->SendMessege($phone, $text);
        $User->update();
        return redirect()->route('hodim.index')->with('success','Hodim blokdan chiqazildi.');
    }
    public function LockClose($id){
        $User = User::find($id);
        $User->status = "false";
        $User->password = "";
        $phone = str_replace(" ","",$User->phone);
        $text = "Xurmatli ".$User->name." sizni ".request()->cookie('filial_name')." o'quv markazidagi ish faoliyatingiz yakunlandi.";
        $this->SendMessege($phone, $text);
        $User->update();
        return redirect()->route('hodim.index')->with('success','Hodim bloklandi.');
    }

    public function create(){
        if((!request()->cookie('filial_id')) OR (!request()->cookie('filial_name'))){
            return redirect()->route('setCookie');
        }else{
            if(Auth::user()->filial == 'NULL'){
                $Filial = Filial::get();
                return view('hodim.create', compact('Filial'));
            }else{
                $Filial = Filial::find(Auth::user()->filial)->get()->first();
                return view('hodim.create', compact('Filial'));
            }
        }
    }
    
    public function store(Request $request){
        if((!request()->cookie('filial_id')) OR (!request()->cookie('filial_name'))){
            return redirect()->route('setCookie');
        }else{
            $validated = $request->validate([
                "filial" => ['required',  'max:255'],
                "name" => ['required',  'max:255'],
                "address" => ['required', 'max:255'],
                "phone" => ['required', 'max:255'],
                "tkun" => ['required', 'max:255'],
                "type" => ['required', 'max:255'],
                "email" => ['required','unique:users', 'max:255'],
                "password" => ['required','min:8']
            ]);
            $validated['status'] = 'true';
            $validated['password'] = Hash::make($request['password']);
            $phone = str_replace(" ","",$request->phone);
            $login = $request->email;
            $parol = $request->password;
            $text = $request->name." ".request()->cookie('filial_name').
            " o'quv markaziga ishga olindingiz. Shaxsiy kabinetga kirish uchun sizning\nLogin:".$login."\nParol: ".$parol."\n".config('api.messege_text');
            $this->SendMessege($phone, $text);
            User::create($validated);
            return redirect()->route('hodim.index')->with('success','Yangi hodim qo\'shildi.');
        }
    }

    public function show(string $id){
        $Users = User::find($id);
        $phone = "998".str_replace(" ","",$Users->phone);
        ### Joriy oydagi to'lovlar ###
        $UserHistory = UserHistory::where('admin_id',$id)->where('created_at','>=',date("Y-m")."-01 00:00:00")->where('created_at','<=',date("Y-m")."-31 23:59:59")->get();
        $Tashrif = 0;
        $TulovNaqt = 0;
        $TulovPlastik = 0;
        $TulovChegirma = 0;
        $TulovQaytarildi = 0;
        $JoriyOy = array();
        foreach ($UserHistory as $key => $value) {
            if($value['status']=='Tashrif'){$Tashrif = $Tashrif + 1;}
            if($value['status']=='TulovNaqt'){if($value['type']=='true'){$TulovNaqt = $TulovNaqt + $value['summa'];}}
            if($value['status']=='TulovPlastik'){if($value['type']=='true'){$TulovPlastik = $TulovPlastik + $value['summa'];}}
            if($value['status']=='TulovChegirma'){$TulovChegirma = $TulovChegirma + $value['summa'];}
            if($value['status']=='TulovQaytarildi'){if($value['type']=='true'){$TulovQaytarildi = $TulovQaytarildi + $value['summa'];}}
        }
        $JoriyOy['Tashrif'] = number_format(($Tashrif), 0, '.', ' ');
        $JoriyOy['JamiTolov'] = number_format(($TulovNaqt+$TulovPlastik), 0, '.', ' ');
        $JoriyOy['TulovNaqt'] = number_format(($TulovNaqt), 0, '.', ' ');
        $JoriyOy['TulovPlastik'] = number_format(($TulovPlastik), 0, '.', ' ');
        $JoriyOy['TulovChegirma'] = number_format(($TulovChegirma), 0, '.', ' ');
        $JoriyOy['TulovQaytarildi'] = number_format(($TulovQaytarildi*(-1)), 0, '.', ' ');
        #dd($JoriyOy);
        ### Hodimga to'langan ish haqi ###
        $IshHaqi = IshHaqi::where('user_id',$id)->where('status','Hodim')->get();
        $HodimTulov = array();
        foreach ($IshHaqi as $key => $value) {
            $HodimTulov[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $HodimTulov[$key]['created_at'] = $value->created_at;
            $HodimTulov[$key]['commit'] = $value->commit;
            $HodimTulov[$key]['admin_id'] = User::where('id',$value->admin_id)->first()->email;
            $HodimTulov[$key]['type'] = $value->type;
        }
        #dd($HodimTulov);
        return view('hodim.show',compact("Users","phone","JoriyOy","HodimTulov"));
    }

    public function edit(string $id){
        $Users = DB::table('users')->find($id);
        return view('hodim.update', compact('Users') );
    }
    public function update(Request $request, string $id){
        $validated = $request->validate([
            "name" => ['required',  'max:255'],
            "address" => ['required', 'max:255'],
            "phone" => ['required', 'max:255'],
            "tkun" => ['required', 'max:255'],
            "type" => ['required', 'max:255'],
            "password" => ['required','min:8']
        ]);

        $phone = str_replace(" ","",$request->phone);
        $parol = $request->password;
        $text = $request->name." ".request()->cookie('filial_name')." o'quv markazi. Ma'lumotlaringiz yangilandi. Shaxsiy kabinetga kirish uchun sizning\nParol: ".$parol."\n".config('api.messege_text');
        $this->SendMessege($phone, $text);

        $validated['password'] = Hash::make($request['password']);
        $Users = DB::table('users')->where('id',$id)->update($validated);
        return redirect()->route('hodim.index')->with('success','Hodim malumotlari yangilandi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
