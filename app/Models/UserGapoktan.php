<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGapoktan extends Model
{
    use HasFactory;

    public $table = "user_gapoktans";

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gapoktan()
    {
        return $this->belongsTo(Gapoktan::class);
    }
}
