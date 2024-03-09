<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruhUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'guruh_id',
        'user_id',
        'start_data',
        'start_commit',
        'start_meneger',
        'status',
        'end_data',
        'end_commit',
        'end_meneger',
    ];
}
