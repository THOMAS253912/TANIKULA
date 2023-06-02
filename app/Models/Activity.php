<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Activity extends Model
{
    use Sluggable, HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity_category()
    {
        return $this->belongsTo(ActivityCategory::class, 'category_activity_id');
    }

    public function notificationActivity()
    {
        return $this->hasMany(NotificationActivity::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    // protected $table = 'activities';
    // protected $fillable = [
    //     'name',
    //     'slug',
    //     'description',
    //     'image',
    // ];
}
