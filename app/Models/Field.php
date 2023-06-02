<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    public $table = "fields";

    protected $guarded = ['id'];

    public function fieldCategory()
    {
        return $this->belongsTo(FieldCategory::class, 'field_category_id');
    }

    public function gapoktan()
    {
        return $this->belongsTo(Gapoktan::class);
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function fieldRecapPlanting()
    {
        return $this->hasMany(FieldRecapPlanting::class);
    }
}
