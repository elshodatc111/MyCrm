<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Transaction;
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

            ### BU JOYDA TO"LOV AMALGA OSHIRILGANDANDAN KIYINGI AMALLAR BAJARILADI ###

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

                #### To'lov Qaytarilganda balansdan minus qilish kerak ####

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
