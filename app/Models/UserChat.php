<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    use HasFactory;

    protected $table = 'user_chat';

    protected $primaryKey = 'id_user_chat';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
