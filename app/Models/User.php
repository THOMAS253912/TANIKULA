<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'fcm_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    // public function plant()
    // {
    //     return $this->hasMany(Plant::class);
    // }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function costumer()
    {
        return $this->hasMany(Costumer::class);
    }

    public function gapoktan()
    {
        return $this->hasMany(Gapoktan::class, 'user_id');
    }

    public function admin()
    {
        return $this->hasMany(Admin::class);
    }

    public function poktan()
    {
        return $this->hasMany(Poktan::class);
    }

    public function farmer()
    {
        return $this->hasMany(Farmer::class);
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function notificationUser()
    {
        return $this->hasMany(NotificationUser::class);
    }

    public function chat()
    {
        return $this->hasMany(Chat::class);
    }

    public function roomChat()
    {
        return $this->hasMany(RoomChat::class);
    }

    public function certificateGapoktan()
    {
        return $this->hasMany(CertificateGapoktan::class);
    }

    public function userGapoktan()
    {
        return $this->hasMany(UserGapoktan::class);
    }

    public function support()
    {
        return $this->hasMany(Support::class);
    }

    public function user_chat()
    {
        return $this->hasOne(UserChat::class, 'user_id', 'id');
    }
}
