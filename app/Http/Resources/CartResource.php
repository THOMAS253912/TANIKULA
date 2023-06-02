<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" =>new UserResource($this->user),
            "product_id" =>new ProductResource($this->product),
            // "session_id" => $this->session_id,
            "product_qty" => $this->product_qty,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
