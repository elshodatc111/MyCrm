<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Talaba;
use App\Models\UserHistory;
use App\Models\StudenHistory;
use App\Models\Guruh;
use App\Models\Tolov;
use App\Models\Setting;
use App\Models\GuruhUser;
use App\Models\Eslatma;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use mrmuminov\eskizuz\Eskiz;
use Carbon\Carbon;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;

class UserController extends Controller{
    public function index(){
        $Users = User::where('filial',request()->cookie('filial_id'))
        ->join('talabas', 'users.id', 'talabas.user_id')->orderBy('users.id', 'DESC')
        ->select('users.name','users.phone','users.address','users.tkun','users.id')->get();
        $User = array();
        foreach ($Users as $key => $value) {
            $User[$key]['name'] = $value->name;
            $User[$key]['phone'] = $value->phone;
            $User[$key]['address'] = $value->address;
            $User[$key]['tkun'] = $value->tkun;
            $User[$key]['id'] = $value->id;
            $GuruhUser = GuruhUser::where('user_id',$value->id)->where('status','true')->get();
            $User[$key]['guruh'] = count($GuruhUser);
        }
        #dd($User);
        return view('users.index',compact('User'));
    }
    public function userDebet(){
        $Debs = array();
        $Summ = array();
        $User = User::where('type','user')->where('filial',request()->cookie('filial_id'))->get();
        $i = 1;
        foreach ($User as $key => $value) {
            $Student_id = $value->id;
            $StudenHistory = StudenHistory::where('studen_histories.student_id',$Student_id)->get();
            $Summa = 0;
            foreach ($StudenHistory as $key => $val) {
                if($val->tulov_id=='NULL'){
                    $Summa = $Summa + $val['summa'];
                }else{
                    $UserHistory = count(UserHistory::where('tulov_id',$val->tulov_id)->where('type','false')->get());
                    if($UserHistory==0){
                        $Summa = $Summa + $val['summa'];
                    }
                }
            }
            if($Summa<0){
                $GuruhUser = count(GuruhUser::where('user_id',$value->id)->where('status','true')->get());
                $Debs[$i]['id'] = $value->id;
                $Debs[$i]['name'] = $value->name;
                $Debs[$i]['phone'] = $value->phone;
                $Debs[$i]['address'] = $value->address;
                $Debs[$i]['gutuhlari'] = $GuruhUser;
                $Debs[$i]['debit'] = number_format(($Summa), 0, '.', ' ');
                $i++;
            }
        }
        return view('users.debit',compact('Debs'));
    }
    public function userPay(){
        $Tulovlar = array();
        $Tolov = Tolov::join('users','users.id','tolovs.user_id')
            ->orderby('tolovs.created_at','desc')
            ->select('users.name','users.id as talaba_id','tolovs.summa','tolovs.type','tolovs.created_at','tolovs.comment','tolovs.admin_id','tolovs.id')
            ->get();
        foreach ($Tolov as $key => $value) {
            $Tulovlar[$key]['talaba_id']=$value->talaba_id;
            $Tulovlar[$key]['talaba']=$value->name;
            $Tulovlar[$key]['summa']=number_format(($value->summa), 0, '.', ' ');
            $Tulovlar[$key]['type']=$value->type;
            $Tulovlar[$key]['created_at']=$value->created_at;
            $Tulovlar[$key]['comment']=$value->comment;
            $Tulovlar[$key]['admin']=User::where('id',$value->admin_id)->get()->first()->email;
            $UserHistory = UserHistory::where('tulov_id',$value->id)->get()->first();
            if($UserHistory->type=='true'){
                $Tulovlar[$key]['status']="true";
            }else{
                $Tulovlar[$key]['status']="false";
            }
        }
        return view('users.pays',compact('Tulovlar'));
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
        $History->tulov_id = 'NULL';
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
        $History->tulov_id = 'NULL';
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
    public function userPasswordUpdate(Request $request){
        $rand = rand(10000000,99999999);
        $User = User::where('id',$request->id)->get()->first();
        $User->password = Hash::make($rand);
        $User->update();
        $phone = str_replace(" ","",$User->phone);
        $text = $request->name." ".request()->cookie('filial_name')." o'quv markazidan shaxsiy kabinetingiz paroli yangilansi. \nParol: ".$rand."\n".config('api.messege_text');
        $this->SendMessege($phone,$text);
        return redirect()->route('user.show',$request->id)->with('success','Talaba paroli yangilandi.');
    }
    public function userSendMessge(Request $request){
        $phone = str_replace(" ","",User::where('id',$request->id)->get()->first()->phone);
        $text = $request->text;
        $this->SendMessege($phone,$text);
        return redirect()->route('user.show',$request->id)->with('success','Talabaga sms xabar yuborildi.');
    }
    public function userAdminChegirma(Request $request){
        #dd($request);
        $Tolov = Tolov::where('user_id',$request->user_id)
        ->where('guruh_id',$request->guruh_id)
        ->where('type',"Chegirma")->get();
        if(count($Tolov)==0){
            $MaxChegirma = Guruh::where('guruhs.id', $request->guruh_id)
                ->join('settings','guruhs.guruh_price', 'settings.summa')
                ->select('settings.admin_chegirma')->get()->first()->admin_chegirma;
            #dd($MaxChegirma);
            if($MaxChegirma>=str_replace(',','',$request->summa)){
                $Tulov = new Tolov();
                $Tulov->filial_id = intval(request()->cookie('filial_id'));
                $Tulov->user_id = $request->user_id;
                $Tulov->guruh_id = $request->guruh_id;
                $Tulov->summa = str_replace(',','',$request->summa);
                $Tulov->type = 'Chegirma';
                $Tulov->comment = $request->text;
                $Tulov->admin_id = Auth::User()->id;
                $Tulov->chegirma_id = 0;
                $Tulov->save();
                $tulov_id = $Tulov->id;
                $StudenHistory = new StudenHistory();
                $StudenHistory->filial_id = intval(request()->cookie('filial_id'));
                $StudenHistory->student_id = $request->user_id;
                $StudenHistory->status = "Tulov";
                $StudenHistory->summa = str_replace(',','',$request->summa);
                $StudenHistory->type = 'Chegirma';
                $StudenHistory->admin_id = Auth::User()->id;
                $StudenHistory->guruh_id = $request->guruh_id;
                $StudenHistory->tulov_id = $tulov_id;
                $StudenHistory->save();

                $UserHistory = new UserHistory();
                $UserHistory->filial_id = intval(request()->cookie('filial_id'));
                $UserHistory->admin_id = Auth::User()->id;
                $UserHistory->status = "TulovChegirma";
                $UserHistory->summa = str_replace(',','',$request->summa);
                $UserHistory->type = 'true';
                $UserHistory->student_id = $request->user_id;
                $UserHistory->izoh = $request->text;
                $UserHistory->tulov_id = $tulov_id;
                $UserHistory->save();

                return back()->withInput()->with('success',"Chegirma kiritildi.");
            }else{
                return back()->withInput()->with('success',"Guruh uchun chegirma max summandan yuqori. Chegirma tasdiqlanmadi.");
            }
        }else{
            return back()->withInput()->with('error',"Talaba siz tanlangan guruh uchun chegirma olgan.");
        }
    }
    public function tkun(){
        $today = Carbon::now()->format('m-d');
        $users = User::where('filial',request()->cookie('filial_id'))->whereRaw("DATE_FORMAT(tkun, '%m-%d') = ?", [$today])->get();
        return view('users.tkun',compact('users'));
    }
    public function show(string $id){
        $thisDay = date('Y-m-d');
        $oldDay = date('Y-m-d',strtotime("-7 days", strtotime($thisDay)));
        ### Guruhga qo'shish uchun guruhlar chiqazish
        $Guruhlar = Guruh::where('guruh_start','>=',$oldDay)->where('filial','=',request()->cookie('filial_id'))->where('status','=','true')->get();
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
        $User = User::where('users.id','=',$id)->join('talabas','talabas.user_id','users.id')->join('user_histories','user_histories.student_id','users.id')->where('user_histories.status','=','Tashrif')->select('users.id','users.name','users.address','users.phone','users.tkun','users.email','users.created_at','talabas.Tanish','talabas.TanishPhone','talabas.BizHaqimizda','user_histories.admin_id','talabas.TalabaHaqida')->get()->first();
        $Guruh_plus['user'] = $User;
        $Users = User::where('id','=',$Guruh_plus['user']->admin_id)->get();
        $Guruh_plus['create_admin'] = $Users->first()->email;
        $Eslatma = Eslatma::where('eslatmas.user_guruh_id',$id)->join('users','users.id','eslatmas.admin_id')->select('users.email','eslatmas.text','eslatmas.created_at','eslatmas.status')->orderby('eslatmas.created_at','DESC')->get();
        $ActivGuruhUser = GuruhUser::where('guruh_users.user_id', $id)->join('guruhs', 'guruhs.id', 'guruh_users.guruh_id')->where('guruh_users.status','true')->where('guruhs.filial',request()->cookie('filial_id'))->select('guruhs.id','guruhs.guruh_name','guruh_users.created_at','guruh_users.start_data','guruh_users.start_commit','guruh_users.start_meneger')->get();
        $Activ_guruh = array();
        foreach($ActivGuruhUser as $key => $item){
            $Activ_guruh[$key]['guruh_name'] = $item->guruh_name;
            $Activ_guruh[$key]['created_at'] = $item->created_at;
            $Activ_guruh[$key]['start_data'] = $item->start_data;
            $Activ_guruh[$key]['start_commit'] = $item->start_commit;
            $Activ_guruh[$key]['guruh_id'] = $item->id;
            $Userssss = User::where('id',$item->start_meneger)->get()->first()->email;
            $Activ_guruh[$key]['start_meneger'] = $Userssss;
        }
        $EndGuruhUser = GuruhUser::where('guruh_users.user_id', $id)->join('guruhs', 'guruhs.id', 'guruh_users.guruh_id')->where('guruh_users.status','false')->select('guruhs.id','guruhs.guruh_name','guruh_users.created_at','guruh_users.start_data', 'guruh_users.start_commit','guruh_users.start_meneger','guruh_users.end_meneger','guruh_users.end_commit','guruh_users.end_data')->get();
        $End_guruh = array();
        foreach($EndGuruhUser as $key => $item){
            $End_guruh[$key]['guruh_name'] = $item->guruh_name;
            $End_guruh[$key]['created_at'] = $item->created_at;
            $End_guruh[$key]['start_data'] = $item->start_data;
            $End_guruh[$key]['end_data'] = $item->end_data;
            $End_guruh[$key]['end_commit'] = $item->end_commit;
            $UserEnd = User::where('id',$item->end_meneger)->get()->first()->email;
            $End_guruh[$key]['end_meneger'] = $UserEnd;
            $End_guruh[$key]['start_commit'] = $item->start_commit;
            $End_guruh[$key]['guruh_id'] = $item->id;
            $Userssss = User::where('id',$item->start_meneger)->get()->first()->email;
            $End_guruh[$key]['start_meneger'] = $Userssss;
        }
        $Guruxx = GuruhUser::where('guruh_users.user_id',$id)->join('guruhs','guruhs.id','guruh_users.guruh_id')->select('guruh_users.guruh_id','guruhs.guruh_name','guruhs.guruh_price','guruhs.guruh_start')->get();
        $chegirmaGuruh = array();
        foreach($Guruxx as $key=>$value){
            $day = Setting::where('summa',$value->guruh_price)->get()->first()->days;
            $thisDay = date("Y-m-d");
            $nextDay = date('Y-m-d',strtotime("+".$day." days", strtotime($value->guruh_start)));
            if($thisDay<=$nextDay){
                $Guruh_Name = $value->guruh_name."(".$value->guruh_name.")";
                $Guruh_id = $value->guruh_id;
                $chegirmaGuruh[$key]['name'] = $Guruh_Name;
                $chegirmaGuruh[$key]['guruh_id'] = $Guruh_id;
            }
        }
        $Admin_chegirma_guruh = GuruhUser::where('guruh_users.user_id',$id)->join('guruhs','guruh_users.guruh_id','guruhs.id')->where('guruh_users.status','true')->select('guruhs.id','guruhs.guruh_name','guruhs.guruh_price')->get();
        $TalabaTulovlari = Tolov::where('tolovs.user_id',$id)->join('user_histories','user_histories.tulov_id','tolovs.id')->join('users','users.id','tolovs.admin_id')->orderby('tolovs.id','DESC')->select('users.email','user_histories.type','tolovs.guruh_id','tolovs.summa','tolovs.type as tulov_type','tolovs.id as tulov_id','tolovs.comment','tolovs.created_at')->get();
        $TalabaTulov = array();
        foreach ($TalabaTulovlari as $key => $value) {
            if($value->guruh_id=='NULL'){
                $TalabaTulov[$key]['guruh'] = "Guruh Tanlanmagan";
            }else{
                $Guruhss = Guruh::where('id',$value->guruh_id)->get()->first()->guruh_name;
                $TalabaTulov[$key]['guruh'] = $Guruhss;
            }
            $TalabaTulov[$key]['email'] = $value->email;
            if($value->type=='true'){
                $TalabaTulov[$key]['tulov_xolati'] = "Tasdiqlangan";
            }else{
                $TalabaTulov[$key]['tulov_xolati'] = "Kutulmoqda";
            }
            $TalabaTulov[$key]['tulov_summa'] = number_format(($value->summa), 0, '.', ' ');
            $TalabaTulov[$key]['tulov_type'] = $value->tulov_type;
            $TalabaTulov[$key]['id'] = $value->tulov_id;
            $TalabaTulov[$key]['comment'] = $value->comment;
            $TalabaTulov[$key]['created_at'] = $value->created_at;
        } 
        $StudenHistory = StudenHistory::where('student_id',$id)->get();
        $i=1;
        $History = array();
        $Balans = 0;
        foreach ($StudenHistory as $key => $value) {
            $Admin_email = User::where('id',$value->admin_id)->get()->first();
            $History[$key]['admin'] = $Admin_email->email;
            $History[$key]['id'] = $value->id;
            $History[$key]['data'] = $value->created_at;
            if($value->status=='Tashrif'){
                $History[$key]['status'] = "Markazga tashrif";
                $History[$key]['summa'] = "";
            }else{
                if($value->status=='GuruhPlus'){
                    $Guruh = Guruh::where('id',$value->guruh_id)->get()->first()->guruh_name;
                    $History[$key]['status'] = "Guruhga qo'shildi: (".$Guruh.")";
                }elseif($value->status=='GuruhDelete'){
                    $Guruh = Guruh::where('id',$value->guruh_id)->get()->first()->guruh_name;
                    $History[$key]['status'] = "Guruhdan o'chirildi: (".$Guruh.")";
                }elseif($value->status=='GuruhDeleteJarima'){
                    $Guruh = Guruh::where('id',$value->guruh_id)->get()->first()->guruh_name;
                    $History[$key]['status'] = "Jarima: (".$Guruh.")";
                }else {
                    if($value->guruh_id=='NULL'){
                        if($value->type=='Naqt'){
                            $History[$key]['status'] = "To'lov: Naqt";
                        }elseif($value->type=='Plastik'){
                            $History[$key]['status'] = "To'lov: Plastik";
                        }elseif($value->type=='Payme'){
                            $History[$key]['status'] = "To'lov: Payme";
                        }
                    }else{
                        if($value->type=='Naqt'){
                            $Guruh = Guruh::where('id',$value->guruh_id)->get()->first()->guruh_name;
                            $History[$key]['status'] = "To'lov: Naqt (".$Guruh.")";
                        }elseif($value->type=='Plastik'){
                            $Guruh = Guruh::where('id',$value->guruh_id)->get()->first()->guruh_name;
                            $History[$key]['status'] = "To'lov: Plastik (".$Guruh.")";
                        }elseif($value->type=='Qaytarildi'){
                            $Guruh = Guruh::where('id',$value->guruh_id)->get()->first()->guruh_name;
                            $History[$key]['status'] = "To'lov: Qaytarildi (".$Guruh.")";
                        }elseif($value->type=='Chegirma'){
                            $Guruh = Guruh::where('id',$value->guruh_id)->get()->first()->guruh_name;
                            $History[$key]['status'] = "To'lov: Chegirma (".$Guruh.")";
                        }elseif($value->type=='Payme'){
                            $Guruh = Guruh::where('id',$value->guruh_id)->get()->first()->guruh_name;
                            $History[$key]['status'] = "To'lov: Payme (".$Guruh.")";
                        }
                    }
                }
                $History[$key]['summa'] = $value->summa;
            }
            if($value->status=='Tashrif'){
                $History[$key]['xisob1'] ="0";
            }elseif($value->summa>0){
                $History[$key]['xisob1'] =$Balans."+".$value->summa;
            }else{
                $History[$key]['xisob1'] =$Balans."".$value->summa;
            }
            $Balans = $Balans+$value->summa;
            $History[$key]['xisob2'] =$Balans;
        }
        $ACTIVNEVguruh = count($ActivGuruhUser);
        $END_guruh = count($EndGuruhUser);
        
        $StudenHistory_balans = StudenHistory::where('student_id',$id)->get();
        $User_Balans = 0;
        $Jami_Naqt_Plastik_Tasdiq = 0;
        $Jami_Naqt_Plastik_Tasdiq_dont = 0;
        $Jami_chegirma_summa = 0;
        foreach ($StudenHistory_balans as $key => $value) {
            if($value->status=='Tulov'){
                if($value->type=='Chegirma'){
                    $User_Balans = $User_Balans + $value->summa;
                    $Jami_chegirma_summa = $Jami_chegirma_summa+$value->summa;
                }else{
                    $Tulov_IDS = $value->tulov_id;
                    $UserHistory_Balans = UserHistory::where('tulov_id',$Tulov_IDS)->get()->first()->type;
                    if($UserHistory_Balans=='true'){
                        $User_Balans = $User_Balans + $value->summa;
                        $Jami_Naqt_Plastik_Tasdiq = $Jami_Naqt_Plastik_Tasdiq+$value->summa;
                    }else{
                        $Jami_Naqt_Plastik_Tasdiq_dont = $Jami_Naqt_Plastik_Tasdiq_dont+$value->summa;
                    }
                }
            }else{
                $User_Balans = $User_Balans + $value->summa;
            }
        }
        $Ballanss = array();
        $Ballanss['JamiBalans'] = number_format(($User_Balans), 0, '.', ' ');
        $Ballanss['Tulov_tasdiqlandi'] = number_format(($Jami_Naqt_Plastik_Tasdiq), 0, '.', ' ');
        $Ballanss['Tulov_tasdiqlanmadi'] = number_format(($Jami_Naqt_Plastik_Tasdiq_dont), 0, '.', ' ');
        $Ballanss['JamiChegirma'] = number_format(($Jami_chegirma_summa), 0, '.', ' ');
        #dd($Ballanss);
        
            
        return view('users.show', compact('Ballanss','ACTIVNEVguruh','END_guruh','History','TalabaTulov','Guruh_plus','Eslatma','Activ_guruh','End_guruh','chegirmaGuruh','Admin_chegirma_guruh'));
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
    public function chegirmadestroy(Request $request){
        $UserHistory = UserHistory::where('tulov_id',$request->tulov_id)->get()->first();
        $StudenHistory = StudenHistory::where('tulov_id',$request->tulov_id)->get()->first();
        $Tolov = Tolov::where('id',$request->tulov_id)->get()->first();
        $UserHistory->delete();
        $StudenHistory->delete();
        $Tolov->delete();
        return $this->show($UserHistory->student_id)->with('success',"Chegirma o'chirildi.");
    }
    public function destroy(string $id){
        $StudenHistory = StudenHistory::where('student_id',$id)->get();
        if(count($StudenHistory)==1){
            $User = User::where('id',$id)->get()->first();
            $StudenHistory = StudenHistory::where('student_id',$id)->get()->first();
            $UserHistory = UserHistory::where('student_id',$id)->get()->first();
            echo "O'chirish mumkun";
            $User->delete();
            $StudenHistory->delete();
            $UserHistory->delete();
            return redirect()->route('user.index')->with('success','Talabani o\'chirildi.');
        }else{
            return redirect()->route('user.index')->with('success','Talabani o\'chirib bo\'lmaydi. Talaba tarixi mavjud.');
        }
        #dd("Talaba guruhlari mavjud bo'lmasa, To'lovlari mavjud bo'lmas talabani o'chirish mumkun qolgan hollarda o'chirish mumkun emas");
    }
}
