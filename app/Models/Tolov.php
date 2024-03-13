<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tolov extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'user_id',
        'guruh_id',
        'summa',
        'type',
        'comment',
        'admin_id',
        'chegirma_id',
    ];
}
