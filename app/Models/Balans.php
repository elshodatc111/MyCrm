<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balans extends Model{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'summa',
        'status',
        'type',
        'start_admin',
        'end_admin',
    ];
}
