<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        "status",
        'summa',
        'type',
        'student_id',
    ];
}
