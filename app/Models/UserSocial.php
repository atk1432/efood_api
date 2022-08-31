<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Comment;
use App\Models\StatusComment;
use App\Models\StatusResponse;
use App\Models\Cart;
use App\Models\Order;


class UserSocial extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'image',
        'access_token',
        'refresh_token',
        'user_social_id'
    ];

    protected $hidden = [
        'id',
        'access_token',
        'refresh_token',
        'user_social_id',
        'role',
        'provider',
        'created_at',
        'updated_at'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function comments() 
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function econComment()
    {
        return $this->hasMany(StatusComment::class, 'user_id');
    }

    public function econResponse() {
        return $this->hasMany(StatusResponse::class, 'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function orders() 
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
