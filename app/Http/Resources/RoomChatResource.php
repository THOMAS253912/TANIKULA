<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomChatResource extends JsonResource
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
            "sender_id" =>new UserResource($this->user),
            "receiver_id" =>new UserResource($this->user),
            "chat_id" =>new ChatResource($this->chat),
            "is_hide" => $this->is_hide,
        ];
    }
}
