<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xarajat extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'summa',
        'comment',
        'type',
        'operator_id',
        'admin_id',
    ];
    
}
