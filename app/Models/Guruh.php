<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guruh extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial',
        'guruh_name',
        'test_id',
        'room_id',
        'guruh_juft_toq',
        'guruh_dars_vaqt',
        'guruh_start',
        'guruh_end',
        'guruh_price',
        'guruh_chegirma',
        'guruh_chegirma_day',
        'techer_id',
        'techer_tulov',
        'techer_bonus',
        'admin_id',
        'admin_chegirma',
        'status'
    ];
}

