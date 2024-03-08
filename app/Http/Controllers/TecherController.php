<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Techer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;

class TecherController extends Controller{
    public function index(){
        $Techer = DB::table('users')
        ->join('techers', 'users.id', 'techers.user_id')
        ->where('users.status','true')
        ->select('users.name','users.phone','users.email','users.tkun','users.address','users.id')
        ->where('users.filial',request()->cookie('filial_id'))->get();
        return view('techers.index', compact('Techer'));
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

    public function techerLock(){
        $Techer = DB::table('users')
        ->join('techers', 'users.id', 'techers.user_id')
        ->where('users.status','false')
        ->select('users.name','users.phone','users.email','users.tkun','users.address','users.id')
        ->where('users.filial',request()->cookie('filial_id'))->get();
        return view('techers.techer-lock', compact('Techer'));
    }

    public function techerLockClose(string $id){
        $Techer = User::find($id);
        $Techer->status = 'true';
        $pass = rand(10000000,99999999);
        $Techer->password = Hash::make($pass);
        $phone = str_replace(" ","",$Techer->phone);
        $login = $Techer->email;
        $parol = $pass;
        $text = $Techer->name." ".request()->cookie('filial_name')." o'quv markaziga ish faoliyatingiz qaytadan tiklandi. Shaxsiy kabinetga kirish uchun sizning\nLogin:".$login."\nParol: ".$parol."\n".config('api.messege_text');
        $this->SendMessege($phone, $text);
        $Techer->update();
        return redirect()->route('techer.index')->with('success','O\'qituvchi bloklandi.');
    }
    public function techerLockopen(string $id){
        $Techer = User::find($id);
        $Techer->status = 'false';
        $Techer->password = 'NULL';
        $phone = str_replace(" ","",$Techer->phone);
        $text = "Xurmatli ".$Techer->name." sizni ".request()->cookie('filial_name')." o'quv markazidagi ish faoliyatingiz yakunlandi.";
        $this->SendMessege($phone, $text);
        $Techer->update();
        return redirect()->route('techer.index')->with('success','O\'qituvchi aktivlashtirildi.');
    }
    
    public function create(){
        return view('techers.create');
    }
    public function store(Request $request){
        $validated = $request->validate([
            "name" => ['required'],
            "address" => ['required'],
            "phone" => ['required'],
            "tkun" => ['required'],
            "email" => ['required','unique:users'],
            "password" => ['required','min:8'],
        ]);
        $validated['password'] = Hash::make($request['password']);
        $validated['status'] = 'true';
        $validated['type'] = 'Techer';
        $validated['filial'] = request()->cookie('filial_id');
        User::create($validated);
        $Users = DB::table('users')->where('email',$request->email)->get()->first();
        $user_id = $Users->id;
        $validated2 = $request->validate([
            "TecherAbout" => ['required'],
            "Mutahasisligi" => ['required'],
        ]);
        $validated2['user_id'] = $user_id;
        $login = $request->email;
        $phone = str_replace(" ","",$request->phone);
        $parol = $request->password;
        $text = $request->name." ".request()->cookie('filial_name')." o'quv markazidan o'qituvchi bo'lib ro'yhatdan o'tdingiz. Shaxsiy kabinetga kirish uchun sizning \nLogin: ".$login."\nParol: ".$parol."\n".config('api.messege_text');
        $this->SendMessege($phone, $text);
        Techer::create($validated2);
        return redirect()->route('techer.index')->with('success','O\'qituvchi qo\'shildi.');
    }

    public function show(string $id){
        return view('techers.show');
    }

    public function edit(string $id){
        $Techer = DB::table('users')->join('techers','users.id','techers.user_id')->where('users.id','=',$id)->get()->first();
        return view('techers.edit',compact('Techer'));
    }
    public function update(Request $request, string $id){
        $validated = $request->validate([
            "name" => ['required'],
            "address" => ['required'],
            "phone" => ['required'],
            "tkun" => ['required'],
            "password" => ['required','min:8'],
        ]);
        $validated2 = $request->validate([
            "TecherAbout" => ['required'],
            "Mutahasisligi" => ['required']
        ]);
        $phone = str_replace(" ","",$request->phone);
        $parol = $request->password;
        $text = $request->name." ".request()->cookie('filial_name')." o'quv markazi. Ma'lumotlaringiz yangilandi. Shaxsiy kabinetga kirish uchun sizning\nParol: ".$parol."\n".config('api.messege_text');
        $this->SendMessege($phone, $text);
        $Techer = DB::table('users')->where('id',$id)->update($validated);
        $About = DB::table('techers')->where('user_id',$id)->update($validated2);
        return redirect()->route('techer.index')->with('success','O\'qituvchi malumotlari yangilandi.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
