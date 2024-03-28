<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Techer;
use App\Models\GuruhUser;
use App\Models\IshHaqiTecher;
use App\Models\Guruh;
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
    
    public function techerPays(string $id){
        $IshHaqiTecher = IshHaqiTecher::where('techer_id',$id)->get();
        $tolovlar = array();
        foreach ($IshHaqiTecher as $key => $value) {
            $tolovlar[$key]['tulov_vaqti'] = $value->created_at;
            $tolovlar[$key]['summa'] = number_format(($value->summa), 0, '.', ' ');
            $tolovlar[$key]['type'] = $value->type;
            $tolovlar[$key]['commit'] = $value->commit;
            $tolovlar[$key]['guruh'] = Guruh::where('id',$value->guruh_id)->first()->guruh_name;
            $tolovlar[$key]['admin'] = User::where('id',$value->admin_id)->first()->email;
        }
        return view('techers.techer_pay', compact('tolovlar'));
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
        $Techer = User::where('users.id',$id)->join('techers','users.id','techers.user_id')->first();
        $setting = array();
        $setting['phone'] = str_replace(' ','',$Techer->phone); // Telegon Raqami
        $kun30 = date('Y-m-d', strtotime('-30 day', time()));       
        $setting['FormGuruh'] = Guruh::where('techer_id',$id)->where('guruh_end','>=',$kun30)->select('id','guruh_name')->get();
        ### Talaba gutuhlari
        $Guruh = Guruh::where('techer_id', $id)->where('guruh_end','>=',$kun30)->get();

        $Guruhlar = array();
        foreach ($Guruh as $key => $value) {
            $Keys = array();
            $Keys['guruh_name']=$value->guruh_name;
            $Keys['guruh_start']=$value->guruh_start;
            $Keys['techer_tulov']=$value->techer_tulov;
            $Keys['techer_bonus']=$value->techer_bonus;
            $Keys['guruh_end']=$value->guruh_end;
            $UserCount = count(GuruhUser::where('guruh_id',$value->id)->where('status','true')->get());
            $Keys['talabalar'] = $UserCount;
            $Talabalar = GuruhUser::where('guruh_id',$value->id)->where('status','true')->get();
            $User1 = 0;
            foreach ($Talabalar as $user) {
                $User_ID = $user->user_id;
                $Guruh_Start = $value->guruh_start;
                $GuruhUser = count(GuruhUser::where('start_data','>',$Guruh_Start)->where('user_id',$User_ID)->where('status','true')->get());
                if($GuruhUser>1){$User1 = $User1 + 1;}
            }
            $Keys['NewUser']=$User1;
            $Keys['TechTulov'] =number_format(($value['techer_tulov']*$UserCount+$value['techer_bonus']*$User1), 0, '.', ' ');
            $IshHaqiTecher = IshHaqiTecher::where('guruh_id',$value->id)->get();
            $Tulov = 0;
            foreach ($IshHaqiTecher as $key => $value) {
                $Tulov = $Tulov + $value->summa;
            }
            $Keys['Tulov']=number_format(($Tulov), 0, '.', ' ');;
            $Guruhlar[$key] = $Keys;
                


        }

        #dd($Guruhlar);


        $setting['NaqtMavjud'] = number_format((5000), 0, '.', ' ');
        $setting['PlastikMavjud'] = number_format((5000), 0, '.', ' ');
        return view('techers.show',compact('Techer','setting','Guruhlar'));
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
