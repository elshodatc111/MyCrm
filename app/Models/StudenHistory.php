<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudenHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'student_id',
        'status',
        'summa',
        'type',
        'admin_id',
        'guruh_id',
        'tulov_id',
    ];
}
