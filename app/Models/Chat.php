<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function roomChat()
    {
        return $this->hasMany(RoomChat::class);
    }

    public function userSender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id', 'id');
    }

    public function userReceiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
