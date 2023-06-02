<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatPemesananResource extends JsonResource
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
            // 'id' => $this->id,
            // "sender_id" => new UserResource($this->user),
            // "receiver_id" => new UserResource($this->user),
            // "chat_id" => new ChatResource($this->chat),
            // "is_hide" => $this->is_hide,

            "id" => $this->id,
            "user_id" => $this->user_id,
            "address_id" => $this->address_id,
            "code" => $this->code,
            "status" => $this->status,
            "order_date" => $this->order_date,
            "payment_due" => $this->payment_due,
            "payment_status" => $this->payment_status,
            "payment_token" => $this->payment_token,
            "payment_url" => $this->payment_url,
            "total_price" => $this->total_price,
            "approved_by" => $this->approved_by,
            "approved_at" => $this->approved_at,
            "cancelled_by" => $this->cancelled_by,
            "cancelled_at" => $this->cancelled_at,
            "cancellation_note" => $this->cancellation_note,
            "review" => $this->review,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "name_billing" => $this->name_billing
        ];
    }
}
