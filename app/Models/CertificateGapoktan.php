<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateGapoktan extends Model
{
    use HasFactory;

    public $table = "certificate_gapoktans";

    protected $guarded = ['id'];

    public function gapoktan()
    {
        return $this->belongsTo(Gapoktan::class);
    }
}
