<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'admin_id',
        "status",
        'summa',
        'type',
        'student_id',
        'izoh',
        'tulov_id',
    ];
}
