<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kassa extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'ChiqimNaqt',
        'ChiqimPlastik',
        'XarajatNaqt',
        'XarajatPlastik',
        'HodimPayNaqt',
        'HodimPayPlastik',
        'TecherPayNaqt',
        'TecherPayPlastik',
    ];
    
}
