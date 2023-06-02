<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "name" => $this->name,
            "slug" => $this->slug,
            "image" => $this->image,
            "category_product_id" => new ProductCategoryResource($this->product_category),
            "code" => $this->code,
            "stoke" => $this->stoke,
            "weight" => $this->weight,
            "stock_out" => $this->stock_out,
            "price" => $this->price,
            "desc" => $this->desc,
            "user_id" => new UserResource($this->user),
            "is_active" => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
