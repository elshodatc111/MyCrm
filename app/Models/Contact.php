<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'user_id',
        'text',
        'user_type',
        'admin_type',
        'admin_id',
        'status',
    ];
}
