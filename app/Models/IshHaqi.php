<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IshHaqi extends Model{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'user_id',
        'status',
        'summa',
        'type',
        'commit',
        'admin_id',
    ];
}
