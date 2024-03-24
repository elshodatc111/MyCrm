<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymePay extends Model
{
    use HasFactory;
    protected $fillable = [
        'tulov_id',
        'history_id',
        'history_chegirma_id',
        'chegirma_id',
        'admin_history',
        'transaction_id',
    ];
}
