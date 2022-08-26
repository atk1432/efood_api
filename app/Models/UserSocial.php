<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Comment;


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
}
