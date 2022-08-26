<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\ProductType;


class ProductCollection extends JsonResource
{

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'types' => ProductType::collection($this->types),
            'rate' => $this->rate,
            'image' => $this->image,
            'description' => $this->description,
            'comments' => count($this->comments),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
