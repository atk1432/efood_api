<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Models\UserSocial;


class ResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $econ = auth()->user() ? auth()->user()->econResponse()
                                ->where('response_id', $this->id)
                                ->first() : '';

        if ($econ != '') {
            $econ = $econ->like ? 'like' : 'dislike';
        }

        return [
            'id' => $this->id,
            'econ' => $econ,
            'like' => count($this->like),
            'dislike' => count($this->dislike),
            'comment' => $this->comment,
            'countResponse' => count($this->responses),
            'user' => new UserResource(UserSocial::find($this->user_id)),
            'created_at' => $this->created_at
        ];
    }
}
