<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller{

    use RegistersUsers;
    
    protected $redirectTo = '/home';
    
    public function __construct(){
        $this->middleware('guest');
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data){
        return User::create([
            'filial' => 'NULL',
            'name' => $data['name'],
            'address' => 'Qarshi shaxar',
            'phone' => '998908830450',
            'tkun' => '02.01.1997',
            'type' => 'SuperAdmin',
            'status' => 'status',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

}
