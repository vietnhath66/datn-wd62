<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\VerifyUserEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',

        'password',
        'phone',
        'avt',
        'status',
        'active_status',
        'dark_mode',
        'messenger_color',
        'email_verified_at',
        'status'
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
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function hasRole($roles)
    {
        return in_array($this->role_id, (array) $roles);
    }

    public function shipperProfile(): HasOne
    {
        return $this->hasOne(ShipperProfile::class, 'user_id', 'id');
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany(Attribute::class, 'user_id');
    }


    public function sendEmailVerificationNotification()
    {
        // Thay vì gửi Notification mặc định, chúng ta gửi Mailable tùy chỉnh
        Mail::to($this->email)->send(new VerifyUserEmail($this));
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }


    public function wishlistedProducts()
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id')->withTimestamps();
    }
}
