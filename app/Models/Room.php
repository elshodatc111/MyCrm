<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model{
    use HasFactory;
    protected $fillable = [
        "filial_id",
        "room_name",
        "room_sigimi",
        "room_max_sigimi",
        "user_id",
        "status"
    ];
}
