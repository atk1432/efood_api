<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (auth()->user()) {
            return [
                'name' => auth()->user()->id == $this->id ? 'You' : $this->name,
                'image' => $this->image
            ];
        } else {
            return [
                'name' => $this->name,
                'image' => $this->image
            ];            
        }
    }
}
