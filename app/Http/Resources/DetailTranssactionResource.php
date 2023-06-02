<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailTranssactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $order_items = $this->orderItems;

        // $order_items_result = [];

        foreach ($order_items as $key => $value) {
            $order_items_result[] = [
                "id"  => $value->id,
                "order_id"  =>  $value->order_id,
                "product_id" =>  [
                    "id" => $value->product->id,
                    "name" => $value->product->name,
                    "slug" => $value->product->slug,
                    "image" => $value->product->image,
                    "category_product_id" => new ProductCategoryResource($value->product->product_category),
                    "code" => $value->product->code,
                    "stoke" => $value->product->stoke,
                    "weight" => $value->product->weight,
                    "stock_out" => $value->product->stock_out,
                    "price" => $value->product->price,
                    "desc" => $value->product->desc,
                    "user_id" => new UserResource($value->product->user),
                    "is_active" => $value->product->is_active,
                    'created_at' => $value->product->created_at,
                    'updated_at' => $value->product->updated_at,
                ],
                "qty" =>  $value->qty,
                "price" =>  $value->price,
                "created_at" =>  $value->created_at,
                "updated_at" =>  $value->updated_at
            ];
            //  $value;
        }




        return [
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
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "name_billing" => $this->name_billing,
            "address" => [
                "id" => $this->address->id,
                "user_id" => $this->address->user_id,
                "recipients_name" => $this->address->recipients_name,
                "telp" => $this->address->telp,
                "address_label" => $this->address->address_label,
                "province_id" => $this->address->province_id,
                "city_id" => $this->address->city_id,
                "district_id" => $this->address->district_id,
                "village_id" => $this->address->village_id,
                "postal_code" => $this->address->postal_code,
                "main_address" => $this->address->main_address,
                "complete_address" => $this->address->complete_address,
                "note_for_courier" => $this->address->note_for_courier,
                "created_at" => $this->address->created_at,
                "updated_at" => $this->address->updated_at,

            ],
            "user" => [
                "id" => $this->user->id,
                "name" => $this->user->name,
                "email" => $this->user->email,
                "email_verified_at" => $this->user->email_verified_at,
                "token" => $this->user->token,
                "token_expire" => $this->user->token_expire,
                "fcm_token" => $this->user->fcm_token,
                "created_at" => $this->user->created_at,
                "updated_at" => $this->user->updated_at,

            ],
            "order_items" => $order_items_result,
        ];
    }
}
