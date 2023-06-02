<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomChat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function userSender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id', 'id');
    }

    public function userReceiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id', 'id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
