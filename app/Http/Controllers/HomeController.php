<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Filial;
use App\Models\Admin;
use App\Models\User;
use App\Models\Room;
use App\Models\Guruh;
use App\Models\Talaba;
use App\Models\GuruhUser;
use App\Models\GuruhJadval;
use App\Models\StudenHistory;
use App\Models\UserHistory;
use App\Models\Contact;
use App\Models\Eslatma;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
    }
    public function userGuruh($id){
        $Guruh = Guruh::find($id);
        $Guruh_about = array();
        $Guruh_about['guruh_name']=$Guruh->guruh_name;
        $Guruh_about['Room']=Room::find($Guruh->room_id)->room_name;
        $Guruh_about['guruh_dars_vaqt']=$Guruh->guruh_dars_vaqt;
        $Guruh_about['guruh_price']=number_format(($Guruh->guruh_price), 0, '.', ' ');
        $Guruh_about['techer']=User::find($Guruh->techer_id)->name;
        $Jadvall = GuruhJadval::where('guruh_id',$id)->get();
        $Jadval = array();
        foreach ($Jadvall as $key => $value) {$Jadval[$key] = $value->days;}
        $Guruh_about['jadval']=$Jadval;
        return view('student.show',compact('Guruh_about'));
    }
    public function index(){
        if((!request()->cookie('filial_id')) AND (!request()->cookie('filial_name'))){return redirect()->route('setCookie');}
        $user = Auth::user();
        if($user->type=='user'){
            ### Talaba haqida ###
            $Users = Talaba::where('user_id',Auth::user()->id)->get()->first();
            $Guruh = GuruhUser::where('guruh_users.user_id',Auth::user()->id)->join('guruhs','guruh_users.guruh_id','guruhs.id')->select('guruhs.guruh_name','guruhs.id','guruhs.guruh_chegirma_day','guruhs.guruh_chegirma','guruhs.guruh_price','guruhs.guruh_start','guruh_users.status','guruhs.guruh_end')->where('guruhs.status','true')->get();
            $Guruhlar = array();
            foreach($Guruh as $key=>$item){
                $Guruhlar[$key]['guruh_name'] = $item->guruh_name;
                $Guruhlar[$key]['id'] = $item->id;
                    if($item->status == 'true'){
                    if($item->guruh_end<date('Y-m-d')){
                        $Guruhlar[$key]['status'] = "YAKUNLANDI";
                    }elseif($item->guruh_start>date('Y-m-d')){
                        $Guruhlar[$key]['status'] = "YANGI";
                    }else{
                        $Guruhlar[$key]['status'] = "JARAYONDA";
                    }
                }else{
                    $Guruhlar[$key]['status'] = "Guruhdan tark etgansiz.";
                }
            }
            ### Chegirma uchun to'lovlar ###
            $Chegirmalar = array();
            $thisDay = date("Y-m-d");
            foreach ($Guruh as $key => $value) {
                if(date("Y-m-d",strtotime('+'.$value->guruh_chegirma_day.' day',strtotime($value->guruh_start)))>=$thisDay){
                    $Chegirmalar[$key]['id'] = $item->id;
                    $Chegirmalar[$key]['guruh_name'] = $item->guruh_name;
                    $Chegirmalar[$key]['guruh_tulov'] = number_format(($item->guruh_price-$item->guruh_chegirma), 0, '.', ' ');
                    $Chegirmalar[$key]['guruh_chegirma'] = number_format(($item->guruh_chegirma), 0, '.', ' ');
                    $Chegirmalar[$key]['guruh_start'] = $value->guruh_start;
                    $Chegirmalar[$key]['days'] = date("Y-m-d",strtotime('+'.$value->guruh_chegirma_day.' day',strtotime($value->guruh_start)));
                }
            }
            ### Talaba Tarixi ####
            $StudenHistory = StudenHistory::where('student_id',Auth::user()->id)->orderby('id','desc')->get();
            $History = array();
            foreach ($StudenHistory as $key => $value) {
                $History[$key]['hodisa'] = $value->status;
                $History[$key]['hodisa_vaqti'] = $value->created_at;
                if($value->status=='GuruhPlus'){
                    $History[$key]['Guruh'] = Guruh::where('id',$value->guruh_id)->get()->first()->guruh_name;
                    $History[$key]['Guruh_narxi'] = number_format(($value->summa*(-1)), 0, '.', ' ')." so'm";
                }elseif($value->status=='GuruhDelete'){
                    $History[$key]['Guruh'] = Guruh::where('id',$value->guruh_id)->get()->first()->guruh_name;
                    $History[$key]['Guruh_narxi'] = number_format(($value->summa), 0, '.', ' ')." so'm";
                    $Jarima = StudenHistory::where('status','GuruhDeleteJarima')
                        ->where('guruh_id',$value->guruh_id)->get()->first();
                    $History[$key]['Guruh_Jarima'] = number_format(($Jarima->summa*(-1)), 0, '.', ' ')." so'm";
                }elseif($value->status=='Tulov'){
                    $UserHistory = UserHistory::where('tulov_id',$value->tulov_id)->get()->first()->type;
                    if($UserHistory=='true'){
                        $History[$key]['Status'] = "Tasdiqlandi";
                    }else{
                        $History[$key]['Status'] = "Kutilmoqda...";
                    }
                    if($value->type=='Qaytarildi'){
                        $History[$key]['summa'] = number_format(($value->summa*(-1)), 0, '.', ' ')." so'm";
                    }elseif($value->type=='Naqt'){
                        $History[$key]['summa'] = number_format(($value->summa), 0, '.', ' ')." so'm";
                    }elseif($value->type=='Plastik'){
                        $History[$key]['summa'] = number_format(($value->summa), 0, '.', ' ')." so'm";
                    }elseif($value->type=='Chegirma'){
                        $History[$key]['summa'] = number_format(($value->summa), 0, '.', ' ')." so'm";
                    }else{
                        $History[$key]['summa'] = number_format(($value->summa), 0, '.', ' ')." so'm";
                    }
                }
                $History[$key]['type'] = $value->type;
            }
            ### Contact ####
            $Contact = Contact::where('user_id',Auth::user()->id)->get();
            $Contacts = array();
            foreach ($Contact as $key => $value) {
                $Contacts[$key]['status'] = $value->status;
                $Contacts[$key]['admin_id'] = $value->admin_id;
                $Contacts[$key]['user_id'] = $value->user_id;
                $Contacts[$key]['text'] = $value->text;
                $Contacts[$key]['user_type'] = $value->user_type;
                $Contacts[$key]['admin_type'] = $value->admin_type;
                $Contacts[$key]['created_at'] = $value->created_at;
                if($value->status=='admin'){
                    $User = User::where('id',$value->admin_id)->get()->first();
                    $Contacts[$key]['name'] = $User->name;
                }
            }
            #dd($Contacts);

            return view('student.index',compact('Users','Guruhlar','Chegirmalar','History','Contacts'));
        }elseif ($user->type=='Techer') {
            return "O'qituvchi profeli tayyor emas";
        }else{
            $Statistika = array();
            $Statistika['techers'] = count(User::where('filial',request()->cookie('filial_id'))->where('type','Techer')->get());
            $Statistika['tashriflar'] = count(User::where('filial',request()->cookie('filial_id'))->where('type','user')->get());
            $Statistika['guruhlar'] = count(Guruh::where('filial',request()->cookie('filial_id'))->get());
            ### Dars Jadvali START ###
            $currentTime = time();
            $weekStart = strtotime('last Monday', $currentTime);
            $Room = Room::where('filial_id',request()->cookie('filial_id'))->get();
            $room_id = 1;
            $Rooms = array();
            foreach($Room as $key => $value ){
                $Rooms[$key]['guruh_id'] = $value->id;
                $Rooms[$key]['room_name'] = $value->room_name;
                $Jadval = array();
                for ($k = 1; $k <= 9; $k++) {
                    for ($i = 0; $i < 6; $i++) {
                        $day = date('Y-m-d', strtotime("+$i days", $weekStart));
                        $GuruhJadval = GuruhJadval::where('room_id',$value->id)->where('times',$k)->where('days',$day)->get();
                        if(count($GuruhJadval)>=1){
                            $guruh_id = $GuruhJadval->first()->guruh_id;
                            $guruh_name = Guruh::where('id',$guruh_id)->get()->first()->guruh_name;
                            $Jadval[$i][$k]['guruh_id'] = $guruh_id;
                            $Jadval[$i][$k]['guruh_name'] = $guruh_name;
                        }else{$Jadval[$i][$k] = 'bosh';}
                    }
                }
                $Rooms[$key]['hafta_kun'] = $Jadval;
            }
            ### Dars Jadvali END ###

            
            return view('home',compact('Statistika','Rooms'));
        }
    }
    
}
