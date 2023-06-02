<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldRecapPlanting extends Model
{
    use HasFactory;

    public $table = "field_recap_plantings";

    protected $guarded = ['id'];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function fieldRecapHarvest()
    {
        return $this->hasMany(FieldRecapHarvest::class);
    }
}
