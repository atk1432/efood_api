<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'comment_id',
        'user_id',
        'response_id'
    ];

    protected $hidden = [
        'comment_id',
        'response_id'
    ];

    public function responses() 
    {
        return $this->hasMany(Response::class);
    }
}
