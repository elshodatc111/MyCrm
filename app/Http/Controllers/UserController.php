<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Talaba;
use App\Models\UserHistory;
use App\Models\StudenHistory;
use App\Models\Guruh;
use App\Models\GuruhUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;

class UserController extends Controller{
    public function index(){
        $Users = User::where('filial',request()->cookie('filial_id'))
        ->join('talabas', 'users.id', 'talabas.user_id')->orderBy('users.id', 'DESC')
        ->select('users.name','users.phone','users.address','users.tkun','users.id')->get();
        return view('users.index',compact('Users'));
    }
    public function userDebet(){
        return view('users.debit');
    }
    public function userPay(){
        return view('users.pays');
    }
    public function create(){
        return view('users.create');
    }
    public function StudentHistory($id){
        $History = new StudenHistory();
        $History->filial_id = request()->cookie('filial_id');
        $History->student_id = $id;
        $History->status = "Tashrif";
        $History->summa = 0;
        $History->type = 0;
        $History->admin_id = Auth::user()->id;
        $History->guruh_id = 0;
        $History->save();
        return true;
    }
    public function UserHistory($id){
        $History = new UserHistory();
        $History->filial_id = request()->cookie('filial_id');
        $History->admin_id = Auth::user()->id;
        $History->status = "Tashrif";
        $History->summa = 0;
        $History->type = 0;
        $History->student_id = $id;
        $History->izoh = 'Yangi talaba';
        $History->save();
        return $this->StudentHistory($id);
    }
    public function store2($phone, $validated){
        $Users = User::where('filial',request()->cookie('filial_id'))
        ->where('phone',$phone)
        ->where('type','user')->get()->first();
        $validated['user_id'] = $Users->id;
        Talaba::create($validated);
        return $this->UserHistory($Users->id);
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
    public function store(Request $request){
        $validated = $request->validate([
            "name" => ['required'],
            "address" => ['required'],
            "phone" => ['required'],
            "tkun" => ['required'],
            "Tanish" => ['required'],
            "TanishPhone" => ['required'],
            "BizHaqimizda" => ['required'],
            "TalabaHaqida" => ['required'],
        ]);
        $Users = User::where('phone',$request->phone)
        ->where('filial',request()->cookie('filial_id'))
        ->where('type','user')->get();
        if(count($Users)>0){
            return back()->withInput()->with('error', "Telefon raqam oldin ro'yhatdan o'tgan.");
        }else{
            $login = time()+1;
            $validated['filial'] = request()->cookie('filial_id');
            $validated['type'] = 'user';
            $validated['status'] = 'true';
            $validated['email'] = $login;
            $validated['password'] = Hash::make('12345678');
            $repet = User::where('name', $validated['name'])
            ->where('address',$validated['address'])
            ->where('type',$validated['type'])
            ->where('email',$validated['email'])
            ->where('phone',$validated['phone'])
            ->where('tkun',$validated['tkun'])->get();
            if(count($repet)){
                return $this->index();
            }else{
                $text = $request->name." ".request()->cookie('filial_name')." o'quv markazidan ro'yhatdan o'tdingiz. Markazimizga tashrifingizdan mamnunmiz!!!. Shaxsiy kabinetga kirish uchun sizning\nLogin:".$login."\nParol: 12345678\n".config('api.messege_text');
                $this->SendMessege(str_replace(" ","",$request->phone),$text);
                User::create($validated);
                $this->store2($validated['phone'],$validated);
                return redirect()->route('user.index')->with('success','Yangi tashrif qo\'shildi.');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id){
        $thisDay = date('Y-m-d');
        $oldDay = date('Y-m-d',strtotime("-7 days", strtotime($thisDay)));
        ### Guruhga qo'shish uchun guruhlar chiqazish
        $Guruhlar = Guruh::where('guruh_start','>=',$oldDay)
        ->where('filial','=',request()->cookie('filial_id'))
        ->where('status','=','true')->get();
        $Guruh_plus = array();
        $i=1;
        foreach ($Guruhlar as $value) {
            $guruh_id = $value['id'];
            $guruh_name = $value['guruh_name'];
            $user_id = $id;
            $GuruhUser = GuruhUser::where('guruh_id','=',$guruh_id)->where('user_id','=',$user_id)->get();
            $guruh = array();
            if(count($GuruhUser)==0){
                $guruh['guruh_id'] = $guruh_id;
                $guruh['guruh_name'] = $guruh_name;
                $Guruh_plus['guruh_plus'][$i] = $guruh;
            }
            $i++;
        }
        if(empty($Guruh_plus)){
            $Guruh_plus['guruh_plus'][0] = '';
        }
        #Talaba haqida malumotlar
        $User = User::where('users.id','=',$id)->join('talabas','talabas.user_id','users.id')
        ->join('user_histories','user_histories.student_id','users.id')->where('user_histories.status','=','Tashrif')
        ->select('users.id','users.name','users.address','users.phone','users.tkun','users.email','users.created_at','talabas.Tanish','talabas.TanishPhone','talabas.BizHaqimizda','user_histories.admin_id','talabas.TalabaHaqida')->get()->first();
        $Guruh_plus['user'] = $User;
        $Users = User::where('id','=',$Guruh_plus['user']->admin_id)->get()->first();
        $Guruh_plus['create_admin'] = $Users->email;
        #dd($Guruh_plus);

        return view('users.show', compact('Guruh_plus'));
    }

    public function edit(string $id){
        if((!request()->cookie('filial_id')) AND (!request()->cookie('filial_name'))){
            return redirect()->route('setCookie');
        }else{
            $user = DB::table('users')->where('id', $id)->first();
            return view('users.update',compact('user'));
        }
    }

    public function update(Request $request, string $id){
        if((!request()->cookie('filial_id')) AND (!request()->cookie('filial_name'))){
            return redirect()->route('setCookie');
        }else{
            $user = DB::table('users')->where('id', $id);
            $validated = $request->validate([
                "name" => ['required'],
                "address" => ['required'],
                "phone" => ['required'],
                "tkun" => ['required']
            ]);
            $Cheked = DB::table('users')->where('filial',request()->cookie('filial_id'))
            ->where('phone',$validated['phone'])->where('type','user')->get();
            if(count($Cheked)>1){
                return back()->withInput()->with('error', "Telefon raqam band.");
            }else{
                $user->update($validated);
                return redirect()->route('user.index')->with('success','Talaba malumotlari yandilandi.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        dd("Talaba guruhlari mavjud bo'lmasa, To'lovlari mavjud bo'lmas talabani o'chirish mumkun qolgan hollarda o'chirish mumkun emas");
    }
}
