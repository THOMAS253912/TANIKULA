<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Education extends Model
{
    use Sluggable, HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //Local Scope
    public function scopeFilter($query, array $filters)
    {
        // Isset Function
        $query->when($filters['pencarian'] ?? false, function($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });

        // Call Back Function
        $query->when($filters['kategori-edukasi'] ?? false, function($query, $education_category) {
            return $query->whereHas('education_category', function($query) use ($education_category) {
                $query->where('slug', $education_category);
            });
        });

        // Aero Function
        $query->when($filters['diposting-oleh'] ?? false, fn($query, $user) =>
            $query->whereHas('user', fn($query) =>
                $query->where('name', $user)
            )
        );
    }

    public function education_category()
    {
        return $this->belongsTo(EducationCategory::class, 'category_education_id');
    }

    public function historyEducation()
    {
        return $this->hasMany(HistoryEducation::class);
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

}
