<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'like',
        'comment_id',
        'user_id'
    ];
}
