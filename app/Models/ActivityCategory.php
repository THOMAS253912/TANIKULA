<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class ActivityCategory extends Model
{
    use Sluggable, HasFactory;

    protected $guarded = ["id"];

    public function activity()
    {
        return $this->hasMany(Activity::class);
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
