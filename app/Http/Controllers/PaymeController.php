<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Guruh;
use App\Models\GuruhUser;
use App\Models\Transaction;
use App\Models\Tolov;
use App\Models\StudenHistory;
use App\Models\PaymePay;
use App\Models\UserHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PaymeController extends Controller{
    public $minAmount = 1;
    public $maxAmount = 9_999_999_99;
    protected int $timeout = 6000*1000;
    public function index(Request $request){
        if($request->method == 'CheckPerformTransaction'){
            if(empty($request->params['account']) && empty($request->params['amount'])){
                $response = [
                    'error' => [
                        'code' => -32504,
                        'message' => 'Malumotlar to\'liq emas'
                    ]
                ];
                return json_encode($response);
            }
            $amount = $request->params['amount'];
            if($amount < $this->minAmount || $amount > $this->maxAmount){
                $response = [
                    'error' => [
                        'code' => -31001,
                        'message'=>[
                            'uz' => 'Summa Not\'g\'ri',
                            'ru' => 'Summa Not\'g\'ri',
                            'en' => 'Summa Not\'g\'ri',
                        ]
                    ]
                ];
                return $response;
            }
            $account = $request->params['account'];
            if(!array_key_exists('onwer_id', $account)){
                $response = [
                    'error' => [
                        'code' => -32504,
                        'message'=>[
                            'uz' => 'Foydalanuvchi topilmadi',
                            'ru' => 'Foydalanuvchi topilmadi',
                            'en' => 'Foydalanuvchi topilmadi',
                        ]
                    ]
                ];
                return $response;
            }
            $user = User::where('id',$account['onwer_id'])->where('type','user')->first();
            if(!$user){
                $response = [
                    'error' => [
                        'code' => -31050,
                        'message'=>[
                            'uz' => 'Foydalanuvchi topilmadi',
                            'ru' => 'Foydalanuvchi topilmadi',
                            'en' => 'Foydalanuvchi topilmadi',
                        ]
                    ]
                ];
                return $response;
            }
            $response = [
                'result' => [
                    'allow' => true,
                ]
            ];
            return json_encode($response);
        }
        elseif($request->method == 'CreateTransaction'){
            if(empty($request->params['account']) && 
                empty($request->params['amount']) && 
                empty($request->params['time']) && empty($request->params['account']['onwer_id'])){
                $response = [
                    'error'=>[
                        'code'=>-32504,
                        'message'=>'Malumotlar yetarli emas.',
                    ]
                ];
                return json_encode($response);
            }
            $id = $request->params['id'];
            $time = $request->params['time'];
            $amount = $request->params['amount'];
            $account = $request->params['account'];
            if(!array_key_exists('onwer_id', $account)){
                $response = [
                    'error' => [
                        'code' => -32504,
                        'message'=>[
                            'uz' => 'Foydalanuvchi topilmadi',
                            'ru' => 'Foydalanuvchi topilmadi',
                            'en' => 'Foydalanuvchi topilmadi',
                        ]
                    ]
                ];
                return $response;
            }
            $user = User::where('id',$account['onwer_id'])->where('type','user')->first();
            if(!$user){
                $response = [
                    'error' => [
                        'code' => -31050,
                        'message'=>[
                            'uz' => 'Foydalanuvchi topilmadi',
                            'ru' => 'Foydalanuvchi topilmadi',
                            'en' => 'Foydalanuvchi topilmadi',
                        ]
                    ]
                ];
                return $response;
            }
            if($amount<$this->minAmount || $amount>$this->maxAmount){
                $response = [
                    'error' => [
                        'code' => -31001,
                        'message'=>[
                            'uz' => 'Summa Not\'g\'ri',
                            'ru' => 'Summa Not\'g\'ri',
                            'en' => 'Summa Not\'g\'ri',
                        ]
                    ]
                ];
                return $response;
            }
            $transaction = Transaction::where('transaction',$id)->first();
            if($transaction){
                if($transaction->state != 1){
                    $response = [
                        'error' => [
                            'code'=>-31001,
                            'message'=>[
                                'uz'=>'Bu operatsiyani bajarish mumkun emas',
                                'ru'=>'Bu operatsiyani bajarish mumkun emas',
                                'en'=>'Bu operatsiyani bajarish mumkun emas',
                            ]
                        ]
                    ];
                    return $response;
                }
                if($transaction->state == 1){
                    $response = [
                        'result'=>[
                            'create_time'=>intval($transaction->create_time),
                            'perform_time' => 0,
                            'cancel_time' => 0,
                            'transaction' => strval($transaction->id),
                            'state' => intval($transaction->state),
                            'reason'=>null
                        ]
                    ];
                    return $response;
                }
                if(!$this->checkTimeout($transaction->create_time)){
                    $transaction->update([
                        'state'=>-1,
                        'reoson'=>4
                    ]);
                    $response = [
                        'error'=>[
                            'code'=>-31008,
                            'message'=>[
                                'uz'=>"To'lov vaqti tugagan",
                                'ru'=>"To'lov vaqti tugagan",
                                'en'=>"To'lov vaqti tugagan",
                            ]
                        ]
                    ];
                    return $response;
                }
                $response = [
                    'result'=>[
                        'create_time'=>$transaction->create_time,
                        'perform_time'=>0,
                        'cancel_time'=>0,
                        'transaction'=>strval($transaction->id),
                        'state'=>$transaction->state,
                        'reason'=>null
                    ]
                ];
                return $response;
            }
            $transaction = Transaction::create([
                'transaction'=>$id,
                'payme_time'=>$time,
                'amount'=>$amount,
                'state'=>1,
                'create_time'=>$this->microtime(),
                'owner_id'=>$account['onwer_id']
            ]);
            $response = [
                'result'=>[
                    'create_time'=>$transaction->create_time,
                    'transaction'=>strval($transaction->id),
                    'state'=>$transaction->state
                ]
            ];
            return $response;
        }
        elseif($request->method == 'CheckTransaction'){
            if(empty($request->params['id'])){
                $response = [
                    'error'=>[
                        'code'=>-32504,
                        'message'=>"Malumotlarda kamchilik mavjud"
                    ]
                ];
                return json_encode($response);
            }
            $id = $request->params['id'];
            $transaction = Transaction::where('transaction',$id)->first();
            if($transaction){
                if($transaction->reason==null){
                    $reason = $transaction->reason;
                }else{
                    $reason = intval($transaction->reason);
                }
                $response = [
                    'result'=>[
                        'create_time'=>intval($transaction->create_time) ?? 0,
                        'perform_time'=>intval($transaction->perform_time) ?? 0,
                        'cancel_time'=>intval($transaction->cancel_time) ?? 0,
                        'transaction'=>strval($transaction->id),
                        'state'=>intval($transaction->state),
                        'reason'=>$reason
                    ]
                ];
                return json_encode($response);
            }else{
                $response = [
                    'error'=>[
                        'code'=>-32504,
                        'message'=>[
                            'uz'=>"Transasia topilmadi",
                            'ru'=>"Transasia topilmadi",
                            'en'=>"Transasia topilmadi",
                        ]
                    ]
                ];
                return json_encode($response);
            }
        }
        if($request->method == 'PerformTransaction'){
            if(empty($request->params['id'])){
                $response = [
                    'error' => [
                        'code' => -32504,
                        'message' => 'Malumotlar to\'liq emas'
                    ]
                ];
                return json_encode($response);
            }
            $id = $request->params['id'];
            $transaction = Transaction::where('transaction',$id)->first();
            if(!$transaction){
                $response = [
                    'error'=>[
                        'code'=> -32504,
                        'message' => [
                            'uz'=>'Transaction topilmadi',
                            'ru'=>'Transaction topilmadi',
                            'en'=>'Transaction topilmadi',
                        ]
                    ]
                ];
                return json_encode($response);
            }
            if($transaction->state!=1){
                if($transaction->state==2){
                    $response = [
                        'result'=>[
                            'state'=>intval($transaction->state),
                            'perform_time'=>intval($transaction->perform_time),
                            'transaction'=>strval($transaction->id),
                        ]
                    ];
                    return json_encode($response);
                }else{
                    $response = [
                        'error'=>[
                            'code'=>-31008,
                            'message' => [
                                'uz'=>'Bu operatsiyani bajarish mumkun emas',
                                'ru'=>'Bu operatsiyani bajarish mumkun emas',
                                'en'=>'Bu operatsiyani bajarish mumkun emas',
                            ]
                        ]
                    ];
                    return $response;
                }
            }
            if(!$this->checkTimeout($transaction->create_time)){
                $transaction->update([
                    'state'=>-1,
                    'reoson'=>4
                ]);
                $response = [
                    'error'=>[
                        'code'=>-31008,
                        'message'=>[
                            'uz'=>"To'lov vaqti tugagan",
                            'ru'=>"To'lov vaqti tugagan",
                            'en'=>"To'lov vaqti tugagan",
                        ]
                    ]
                ];
                return $response;
            }
            $transaction->state=2;
            $transaction->perform_time = $this->microtime();
            $transaction->save();
            $user_id = $transaction->owner_id;
            $filial_id = User::where('id',$user_id)->first()->filial;
            $GuruhUser = GuruhUser::where('user_id',$user_id)->where('status','true')->get();
            $Tolov = Tolov::create([
                'filial_id'=>$filial_id,
                'user_id'=>$user_id,
                'guruh_id'=>'NULL',
                'summa'=>$transaction->amount,
                'type'=>'Payme',
                'comment'=>"Shaxsiy kabinet orqali to'lov",
                'admin_id'=>1,
                'chegirma_id'=>0,
            ]);
            $UserHistory = UserHistory::create([
                'filial_id'=>$filial_id,
                'admin_id'=>1,
                "status"=>'Payme',
                'summa'=>$transaction->amount,
                'type'=>'true',
                'student_id'=>$user_id,
                'izoh'=>"Payme orqali to'lov",
                'tulov_id'=>$Tolov->id
            ]);
            $StudenHistory = StudenHistory::create([
                'filial_id'=>$filial_id,
                'student_id'=>$user_id,
                'status'=>'Tulov',
                'summa'=>$transaction->amount,
                'type'=>'Payme',
                'admin_id'=>1,
                'guruh_id'=>'NULL',
                'tulov_id'=>$Tolov->id,
            ]);    
            $PaymePay = PaymePay::create([
                'tulov_id'=>$Tolov->id,
                'history_id'=>$StudenHistory->id,
                'history_chegirma_id'=>0,
                'chegirma_id'=>0,
                'admin_history'=>$UserHistory->id,
                'transaction_id'=>$transaction->id,
            ]);
            foreach ($GuruhUser as $key => $value) {
                $Guruh = Guruh::where('id',$value->guruh_id)->first();
                $ChegirmaTulov = $Guruh->guruh_price-$Guruh->guruh_chegirma;
                $guruh_chegirma_day = $Guruh->guruh_chegirma_day;
                $guruh_start = $Guruh->guruh_start;
                $thisDay = date("Y-m-d");
                $Chegirma_Muddat = date('Y-m-d', strtotime("+".$guruh_chegirma_day." day", strtotime($guruh_start)));
                if($Chegirma_Muddat>=$thisDay){
                    if($transaction->amount == $ChegirmaTulov){
                        $Tolovlar = Tolov::where('user_id',$user_id)->where('guruh_id',$value->guruh_id)->first();
                        if(!$Tolovlar){
                            $Tolov2 = Tolov::create([
                                'filial_id'=>$filial_id,
                                'user_id'=>$user_id,
                                'guruh_id'=>$Guruh->id,
                                'summa'=>$Guruh->guruh_chegirma,
                                'type'=>'Chegirma',
                                'comment'=>"Payme orqali to'lov",
                                'admin_id'=>1,
                                'chegirma_id'=>0,
                            ]);
                            $UserHistory2 = UserHistory::create([
                                'filial_id'=>$filial_id,
                                'admin_id'=>1,
                                "status"=>'Chegirma',
                                'summa'=>$Guruh->guruh_chegirma,
                                'type'=>'true',
                                'student_id'=>$user_id,
                                'izoh'=>"Payme orqali to'lov",
                                'tulov_id'=>$Tolov2->id
                            ]);
                            $StudenHistory2 = StudenHistory::create([
                                'filial_id'=>$filial_id,
                                'student_id'=>$user_id,
                                'status'=>'Tulov',
                                'summa'=>$Guruh->guruh_chegirma,
                                'type'=>'Chegirma',
                                'admin_id'=>1,
                                'guruh_id'=>$Guruh->id,
                                'tulov_id'=>$Tolov2->id,
                            ]);
                            StudenHistory::where('id',$StudenHistory->id)->update([
                                'guruh_id'=>$Guruh->id,
                            ]);   
                            Tolov::where('id',$Tolov->id)->update([
                                'guruh_id'=>$Guruh->id,
                            ]);
                            PaymePay::where('id',$PaymePay->id)->update([
                                'history_chegirma_id'=>$UserHistory2->id,
                                'history_chegirma_id'=>$StudenHistory2->id,
                                'chegirma_id'=>$Tolov2->id
                            ]);
                            break;
                        }
                    }
                }
            }
            $response = [
                'result'=>[
                    'state'=>$transaction->state,
                    'perform_time'=>$transaction->perform_time,
                    'transaction'=>strval($transaction->id)
                ]
            ];
            return json_encode($response);
        }
        elseif($request->method == 'CancelTransaction'){
            if(empty($request->params['id']) AND empty($request->params['reason'])){
                $response = [
                    'error' => [
                        'code' => -32504,
                        'message' => "Malumotlar to'liq emas"
                    ]
                ];
                return json_encode($response);
            }
            if(!array_key_exists('reason',$request->params)){
                $response = [
                    'error'=>[
                        'code'=>-32504,
                        'message'=>[
                            'uz'=>'Notogri formatda yuborildi',
                            'ru'=>'Notogri formatda yuborildi',
                            'en'=>'Notogri formatda yuborildi',
                        ]
                    ]
                ];
                return $response;
            }
            $id = $request->params['id'];
            $reason = $request->params['reason'];
            $transaction = Transaction::where('transaction',$id)->first();
            if(!$transaction){
                $response = [
                    'error'=>[
                        'code'=>-31003,
                        'message'=>[
                            'uz'=>'Transaction Topilmadi',
                            'ru'=>'Transaction Topilmadi',
                            'en'=>'Transaction Topilmadi',
                        ]
                    ]
                ];
                return json_encode($transaction);
            }
            if($transaction->state == 1){
                $cancel_time = $this->microtime();
                $transaction->update([
                    'state' => -1,
                    'cancel_time' => $cancel_time,
                    'reason' => $reason
                ]);
                $response = [
                    'result' =>[
                        'state' => intval($transaction->state),
                        'cancel_time' => intval($transaction->cancel_time),
                        'transaction' => strval($transaction->id)
                    ]
                ];
                return $response;
            }
            if($transaction->state == -1){
                $response = [
                    'result' =>[
                        'state' => intval($transaction->state),
                        'cancel_time' => intval($transaction->cancel_time),
                        'transaction' => strval($transaction->id)
                    ]
                ];
                return $response;
            }
            if($transaction->state == -2){
                $response = [
                    'result' =>[
                        'state' => intval($transaction->state),
                        'cancel_time' => intval($transaction->cancel_time),
                        'transaction' => strval($transaction->id)
                    ]
                ];
                return $response;
            }
            if($transaction->state == 2){
                $cancel_time = $this->microtime();
                $transaction->update([
                    'state' => -2,
                    'cancel_time' => $cancel_time,
                    'reason' => $reason
                ]);
                $PaymePay = PaymePay::where('transaction_id',$transaction->id)->first();
                $admin_history = $PaymePay->admin_history;
                $tulov_id1 = $PaymePay->tulov_id;
                $Tulov1 = Tolov::where('id',$tulov_id1)->first();
                $Tulov1->delete();
                $UserHistory = UserHistory::where('id',$admin_history)->first();
                $UserHistory->delete();
                $history_id1 = $PaymePay->history_id;
                $StudenHistory1 = StudenHistory::where('id',$history_id1)->first();
                $StudenHistory1->delete();
                $tulov_id2 = $PaymePay->chegirma_id;
                if($tulov_id2 != 0){
                    $Tulov2 = Tolov::where('id',$tulov_id2)->first();
                    $Tulov2->delete();
                }
                $history_id2 = $PaymePay->history_chegirma_id;
                if($history_id2 != 0){
                    $StudenHistory2 = StudenHistory::where('id',$history_id2)->first();
                    $StudenHistory2->delete();
                }
                $response = [
                    'result' =>[
                        'state' => intval($transaction->state),
                        'cancel_time' => intval($transaction->cancel_time),
                        'transaction' => strval($transaction->id)
                    ]
                ];
                return $response;
            }
        }
        elseif($request->method == 'GetStatement'){
            $from = $request->params['from'];
            $to = $request->params['to'];
            $transaction = Transaction::where('payme_time',">=",$from)->where('payme_time','<=',$to)->get()->first();
            if(empty($transaction)){
                $response = [
                    'id'=>$request->id,
                    'error'=>[
                        'code' => -32504,
                        'message' =>"Bu maydon bo'sh"
                    ]
                ];
                return json_encode($response);
            }else{
                $response = array();
                $i=0;
                foreach ($transaction as $value) {
                    $response['result']['transaction'][$i]['id'] = $transaction->paycom_transaction_id;
                    $response['result']['transaction'][$i]['time'] = $transaction->payme_time;
                    $response['result']['transaction'][$i]['amount'] = $transaction->amount;
                    $response['result']['transaction'][$i]['account']['onwer_id'] = $transaction->owner_id;
                    $response['result']['transaction'][$i]['create_time'] = intval($transaction->payme_time);
                    $response['result']['transaction'][$i]['perform_time'] = intval($transaction->perform_time_unix);
                    $response['result']['transaction'][$i]['cancel_time'] = intval($transaction->cancel_time) ?? 0;
                    $response['result']['transaction'][$i]['transaction'] = $transaction->paycom_transaction_id;
                    $response['result']['transaction'][$i]['state'] = $transaction->state;
                    $response['result']['transaction'][$i]['reason'] = $transaction->reason;
                    $i++;
                }
                return json_encode($response);
            }
        }
        else if($request->method =='ChangePassword'){
            $response = [
                'id'=>$request->id,
                'error'=>[
                    'code' => -32504,
                    'message' =>"ChangePassword"
                ]
            ];
            return json_encode($response);
        }
    }

    protected function microtime():int{
        return (time() * 1000);
    }
    protected function checkTimeout($created_time){
        return ($this->microtime()) <= ($created_time + $this->timeout);
    }
}
