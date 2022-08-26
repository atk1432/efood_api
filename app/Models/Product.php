<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Type;
use App\Models\Comment;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description'
    ];

    public static function findApi($id)
    {
        $product = Product::find($id);

        if (!$product) return [];

        return $product;
    }

    public function types() 
    {
        return $this->belongsToMany(Type::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function other_comments() 
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function my_comments()
    {
        return $this->hasMany(Comment::class)
                    ->where('user_id', auth()->user()->id)->latest();
    }
}
