<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'summa',
        'days',
        'chegirma',
        'admin_chegirma',
        'filial_id',
    ];
    
}
