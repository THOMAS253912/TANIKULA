<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public $table = "indonesia_provinces";
    // public $table = "provinces";

    protected $guarded = ['id'];
}
