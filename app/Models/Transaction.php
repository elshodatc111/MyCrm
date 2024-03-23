<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction',
        'code',
        'state',
        'owner_id',
        'amount',
        'reason',
        'payme_time',
        'cancel_time',
        'create_time',
        'perform_time',
    ];
}
