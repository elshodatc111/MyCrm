<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruhJadval extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'room_id',
        'guruh_id',
        'days',
        'times',
    ];
}
