<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Response;


class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'rate',
        'product_id',
        'user_id'
    ];

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
