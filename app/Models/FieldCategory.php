<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldCategory extends Model
{
    use HasFactory;

    public $table = "field_categories";

    protected $guarded = ['id'];

    public function field()
    {
        return $this->hasMany(Field::class);
    }

    public function gapoktan()
    {
        return $this->belongsTo(Gapoktan::class);
    }
}
