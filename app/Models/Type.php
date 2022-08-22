<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    public static function check_exist($types) 
    {   
        $not_exists = [];
        $exists = [];

        foreach ($types as $type) {
            $data = Type::where('name', $type)->first();
            if (!$data) {
                array_push($not_exists, $type);
            } else {
                array_push($exists, $data);
            }
        }

        if ($not_exists) {
            return [
                'success' => false,
                'errors' => array_map(function ($data) {
                    return '"'.$data.'"'." không tồn tại.";
                }, $not_exists)
            ];
        } else {
            return [
                'success' => true,
                'data' => $exists
            ];
        }
    }
}
