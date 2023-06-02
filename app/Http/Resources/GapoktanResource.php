<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GapoktanResource extends JsonResource
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
            "chairman" => $this->chairman,
            "city" => $this->city,
            "address" => $this->address,
            "telp" => $this->telp,
            "image" => $this->image, 
            "is_active" => $this->is_active,
        ];
    }
}
