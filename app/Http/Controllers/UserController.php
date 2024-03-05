<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Talaba;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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
    public function store2($phone, $validated){
        $Users = User::where('filial',request()->cookie('filial_id'))
        ->where('phone',$phone)
        ->where('type','user')->get()->first();
        $validated['user_id'] = $Users->id;
        Talaba::create($validated);
        return true;
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
            $validated['filial'] = request()->cookie('filial_id');
            $validated['type'] = 'user';
            $validated['status'] = 'true';
            $validated['email'] = time()+1;
            $validated['password'] = Hash::make($request['password']);
            $repet = User::where('name', $validated['name'])
            ->where('address',$validated['address'])
            ->where('type',$validated['type'])
            ->where('email',$validated['email'])
            ->where('phone',$validated['phone'])
            ->where('tkun',$validated['tkun'])->get();
            if(count($repet)){
                return $this->index();
            }else{
                User::create($validated);
                $this->store2($validated['phone'],$validated);
                return redirect()->route('user.index')->with('success','Yangi tashrif qo\'shildi.');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id){
        dd($id);
        return view('users.update');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
