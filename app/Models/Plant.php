<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function poktan()
    {
        return $this->belongsTo(Poktan::class);
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function notificationPlant()
    {
        return $this->hasMany(NotificationPlant::class);
    }
}
