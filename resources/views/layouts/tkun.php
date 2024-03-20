<?php
use Carbon\Carbon;
use App\Models\TKun;
use mrmuminov\eskizuz\Eskiz;
use mrmuminov\eskizuz\types\sms\SmsSingleSmsType;

$today = Carbon::today();
$numberOfBirthdaysToday = DB::table('users')
    ->where('filial',request()->cookie('filial_id'))
    ->whereRaw("DATE_FORMAT(tkun, '%m-%d') = ?", [$today->format('m-d')])->count();
echo $numberOfBirthdaysToday;

function SendMessege($phone,$text){
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

if($numberOfBirthdaysToday>0){
    $TKun = count(TKun::where('data',date('Y-m-d'))->where('status',0)->get());
    if($TKun>0){
        
    }else{
        $Messege = DB::table('users')->whereRaw("DATE_FORMAT(tkun, '%m-%d') = ?", [$today->format('m-d')])->get();
        foreach ($Messege as $key => $value) {
            $phone = str_replace(" ","",$value->phone);
            $text = $value->name." Assalomu alaykum";
            SendMessege($phone,$text);
        }
        TKun::insert([
            'data' => date('Y-m-d'),
            'status' => 0
        ]);
    }        
}