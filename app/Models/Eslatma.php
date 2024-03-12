<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eslatma extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'admin_id',
        'type',
        'status',
        'text',
        'user_guruh_id',
    ];
}
