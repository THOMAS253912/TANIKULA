<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            "user_id" => new UserResource($this->user),
            "recipients_name" => $this->recipients_name,
            "telp" => $this->telp,
            "address_label" => $this->address_label,
            "provinsi_id" => $this->provinsi_id,
            "kota_id" => $this->kota_id,
            "postal_code" => $this->postal_code,
            "main_address" => $this->main_address,
            "complete_address" => $this->complete_address,
            "note_for_courier" => $this->note_for_courier,
        ];
    }
}
