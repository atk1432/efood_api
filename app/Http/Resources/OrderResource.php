<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\Models\UserInfo;


class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->status == 1) {
            $status = 'Đang chờ';
        } else if ($this->status == 2) {
            $status = 'Đang xử lí';
        } else if ($this->status == 3) {
            $status = 'Đã xử lí';
        }

        return [
            'id' => $this->id,
            'product' => new ProductCollection(Product::find($this->product_id)),
            'user_info' => UserInfo::find($this->user_info_id),
            'amount' => $this->amount,
            'status' => $status,
            'created_at' => $this->created_at
        ];
    }
}
