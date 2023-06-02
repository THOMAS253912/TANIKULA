<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldRecapHarvest extends Model
{
    use HasFactory;

    public $table = "field_recap_harvests";

    protected $guarded = ['id'];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function fieldRecapPlanting()
    {
        return $this->belongsTo(FieldRecapPlanting::class, 'planting_id');
    }
}
