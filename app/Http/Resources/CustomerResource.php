<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            "address_id" => $this->address_id,
            "gender" => $this->gender,
            "birth" => $this->birth,
            "telp" => $this->telp,
            "image" => $this->image,
        ];
    }
}
