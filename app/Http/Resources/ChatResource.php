<?php

namespace App\Http\Resources;

use App\Models\ParticipantChat;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            "sender_id" =>new UserResource($this->userSender),
            "receiver_id" =>new UserResource($this->userReceiver),
            "is_hide" => $this->is_hide,
            "is_read" => $this->is_read,
            "text" => $this->text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
