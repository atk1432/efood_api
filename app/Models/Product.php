<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Type;


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
}
