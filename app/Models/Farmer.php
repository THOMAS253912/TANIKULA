<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poktan()
    {
        return $this->belongsTo(Poktan::class);
    }

    public function plant()
    {
        return $this->hasMany(Plant::class);
    }

    public function historyEducation()
    {
        return $this->hasMany(HistoryEducation::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function field()
    {
        return $this->hasMany(Field::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function gapoktan()
    {
        return $this->belongsTo(Gapoktan::class);
    }

    public function farmer()
    {
        return $this->hasMany(Farmer::class);
    }

    public function fieldRecapPlanting()
    {
        return $this->hasMany(FieldRecapPlanting::class);
    }

    public function fieldRecapHarvest()
    {
        return $this->hasMany(FieldRecapHarvest::class);
    }
}
