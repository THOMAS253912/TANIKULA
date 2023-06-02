<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gapoktan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->hasMany(Field::class);
    }

    public function poktan()
    {
        return $this->hasMany(Poktan::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
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

    public function certificateGapoktan()
    {
        return $this->hasMany(CertificateGapoktan::class);
    }

    public function farmer()
    {
        return $this->hasMany(Farmer::class);
    }

    public function productCategory()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function educationCategory()
    {
        return $this->hasMany(EducationCategory::class);
    }

    public function activityCategory()
    {
        return $this->hasMany(ActivityCategory::class);
    }

    public function fieldCategory()
    {
        return $this->hasMany(FieldCategory::class);
    }
}
