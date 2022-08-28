<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'like',
        'response_id',
        'user_id'
    ];
}
