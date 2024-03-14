<?php

namespace App\Http\Controllers;

use App\Models\GuruhUser;
use App\Models\Guruh;
use App\Models\StudenHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;
class GuruhUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Talabani gutuhga qo'shish
     */
    public function store(Request $request){
        $validated = $request->validate([
            "user_id" => ['required'],
            "guruh_id" => ['required'],
            "start_commit" => ['required'],
        ]);
        $validated['start_data'] = date('Y-m-d');
        $validated['start_meneger'] = Auth::user()->id;
        $validated['status'] = 'true';
        $validated['end_data'] = "NULL";
        $validated['end_commit'] = "NULL";
        $validated['end_meneger'] = "NULL";
        $History = GuruhUser::where('user_id','=',$request->user_id)->where('guruh_id','=',$request->guruh_id)->get();
        if(count($History)>0){
            return redirect()->route('user.show',$request->user_id)->with('success','Yangi guruhga qo\'shildi.');
        }else{
            GuruhUser::create($validated);
            $summa = Guruh::where('id',$request->guruh_id)->get()->first()->guruh_price;
            $status = 'GuruhPlus';
            $type = 0;
            $guruh_id = $request->guruh_id;
            $admin_id = Auth::user()->id;
            $student_id = $request->user_id;
            $filial_id = request()->cookie('filial_id');
            $historys = new StudenHistory();
            $historys->summa = -$summa;
            $historys->status = $status;
            $historys->type = $type;
            $historys->guruh_id = $guruh_id;
            $historys->admin_id = $admin_id;
            $historys->student_id = $student_id;
            $historys->filial_id = $filial_id;
            $historys->tulov_id = 'NULL';
            $historys-> save();
            return redirect()->route('user.show',$request->user_id)->with('success','Yangi guruhga qo\'shildi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GuruhUser $guruhUser)
    {
        //
    }
    
    

    public function sendMessege(Request $request){
        $GuruhUser = GuruhUser::where('guruh_users.guruh_id',$request->guruh_id)
        ->join('users','users.id','guruh_users.user_id')
        ->select('users.phone','users.id','users.name')
        ->where('guruh_users.status','true')->get();
        $phone = array();
        $i = 0;
        foreach ($GuruhUser as $key => $value) {
            $req_id = $value->id;
            if($request[$req_id]=='on'){
                $Phone = "+998".str_replace(" ","",$value->phone);
                $phone[$key]['mobile_phone'] = $Phone;
                $phone[$key]['message'] = $request->text;
                $i++;
            }
        }
        foreach ($phone as $key => $value) {
            echo $value['mobile_phone']."<br>";
            $eskiz = new Eskiz(config('api.eskiz_email'),config('api.eskiz_password'));
            $eskiz->requestAuthLogin();
            $singleSmsType = new SmsSingleSmsType(
                from: '4546',
                message: $value['message'],
                mobile_phone: $value['mobile_phone'],
                user_sms_id: $key+1,
                callback_url: ''
            );
            $result = $eskiz->requestSmsSend($singleSmsType);
            if($result->getResponse()->isSuccess == true){
                echo "Send ";
            }else{ echo "Error "; }
        }
        return back()->withInput()->with('success', $i." Talabaga sms xabar yuborildi.");
    }
    public function edit(GuruhUser $guruhUser){
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $validated = $request->validate([
            "end_commit" => ['required'],
            "user_id" => ['required'],
            "summa" => ['required'],
        ]);
        $validated['end_data']=date('Y-m-d');
        $validated['status']='false';
        $validated['end_meneger']=Auth::user()->id;
        $GuruhUser = GuruhUser::where('guruh_id',$id)
        ->where('user_id',$request->user_id)->get()->first();
        $GuruhUser->update($validated);
        $validated2 = array();
        $validated2['filial_id']=request()->cookie('filial_id');
        $validated2['student_id']=$request->user_id;
        $validated2['status']='GuruhDelete';
        $validated2['summa']=$request->guruh_summa;
        $validated2['type']=0;
        $validated2['admin_id']=Auth::user()->id;
        $validated2['guruh_id']=$id;
        $validated2['tulov_id']="NULL";
        $validated3 = array();
        $validated3['filial_id']=request()->cookie('filial_id');
        $validated3['student_id']=$request->user_id;
        $validated3['status']='GuruhDeleteJarima';
        $validated3['summa']=-$validated['summa'];
        $validated3['type']=0;
        $validated3['admin_id']=Auth::user()->id;
        $validated3['guruh_id']=$id;
        $validated3['tulov_id']="NULL";
        #dd($request);
        StudenHistory::create($validated2);
        StudenHistory::create($validated3);
        return redirect()->route('guruh.show',$id)->with('success','Guruhdan talaba o\'chirildi.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuruhUser $guruhUser)
    {
        //
    }
}
