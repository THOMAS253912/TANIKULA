<?php

namespace App\Http\Resources\Gapoktan;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            "category_activity_id" => new ActivityCategoryResource($this->activity_category),
            "title" => $this->title,
            "slug" => $this->slug,
            "date" => $this->date,
            "desc" =>  $this->desc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
