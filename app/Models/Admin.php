<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','user_edet','user_delete','guruh_edet','guruh_delete','hisobotlar','statistika','moliya','moliya_tasdiqlash','techer','techer_edit','techer_delete','hodim','hodim_edit','hodim_delete','xonalar','xonalar_edet','xonalar_delete','mening_balansim'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
