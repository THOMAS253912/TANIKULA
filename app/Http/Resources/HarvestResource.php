<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HarvestResource extends JsonResource
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
            'farmer_name' => $this->farmer->user->name,
            'field_category_name' => $this->fieldRecapPlanting->field->fieldCategory->name,
            'field_category_details' => $this->fieldRecapPlanting->field->fieldCategory->details,
            // 'farmer_id' => new FarmerResource($this->farmer_id),
            // 'poktan_id' =>  new PoktanResource($this->poktan),
            // "plant_tanaman" => $this->plant_tanaman,
            // 'surface_area' => $this->surface_area,
            // 'address' => $this->address,
            // 'plating_date' => $this->plating_date,
            // 'harvest_date' => $this->harvest_date,
            'date_harvest' => $this->date_harvest,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'name' => $this->name,
            //
            'planting_id' => $this->fieldRecapPlanting->id,
            'field_id' => $this->fieldRecapPlanting->field->id,

        ];
    }
}
