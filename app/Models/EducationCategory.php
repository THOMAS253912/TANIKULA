<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class EducationCategory extends Model
{
    use Sluggable, HasFactory;

    protected $guarded = ['id'];

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function gapoktan()
    {
        return $this->belongsTo(Gapoktan::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
