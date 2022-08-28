<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Models\UserSocial;


class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $econ = auth()->user() ? auth()->user()->econComment()
                                ->where('comment_id', $this->id)
                                ->first() : '';

        if ($econ != '') {
            $econ = $econ->like ? 'like' : 'dislike';
        }

        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'rate' => $this->rate,
            'like' => count($this->like),
            'dislike' => count($this->dislike),
            'econ' => $econ,
            'countResponse' => count($this->responses),
            'user' => new UserResource(UserSocial::find($this->user_id)),
        ];
    }
}
