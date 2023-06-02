<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use Sluggable, HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_product_id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function photo_product()
    {
        return $this->hasMany(PhotoProduct::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function chat()
    {
        return $this->hasMany(Chat::class);
    }

    //Local Scope
    public function scopeFilter($query, array $filters)
    {
        // Isset Function
        $query->when($filters['pencarian'] ?? false, function ($query, $search) {
            return $query->where('products.name', 'like', '%' . $search . '%');
        });
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
