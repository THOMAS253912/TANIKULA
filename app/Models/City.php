<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public $table = "indonesia_cities";
    // public $table = "cities";

    protected $guarded = ['id'];
}
