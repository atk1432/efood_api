<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'firstname',
        'lastname',
        'address',
        'info_for_shipper'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
