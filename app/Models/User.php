<?php

namespace App\Models;

use App\Models\Talaba;
use App\Models\Techer;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    
    protected $fillable = ['filial','status','name','address','phone','tkun','type','status','email','password',];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function Talaba(){
        return $this->hasOne(Talaba::class);
    }

    public function Techer(){
        return $this->hasOne(Techer::class);
    }
    
    public function Admin(){
        return $this->hasOne(Admin::class);
    }
    
}
