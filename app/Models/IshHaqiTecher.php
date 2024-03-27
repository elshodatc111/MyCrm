<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IshHaqiTecher extends Model
{
    use HasFactory; 
    protected $fillable = [
        'filial_id',
        'techer_id',
        'guruh_id',
        'status',
        'summa',
        'type',
        'commit',
        'admin_id',
    ];
}
