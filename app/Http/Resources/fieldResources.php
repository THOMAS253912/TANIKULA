<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class fieldResources extends JsonResource
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
            'id' => $this->id,
            'field_category_name' => $this->fieldCategory->name,
            'field_category_details' => $this->fieldCategory->details,
            'gapoktan_name' => $this->gapoktan->user->name,
            'farmer_name' => $this->farmer->user->name,
        ];
    }
}
