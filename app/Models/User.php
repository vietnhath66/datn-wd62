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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


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
        'is_locked'
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
        'is_locked' => 'boolean',
    ];

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function hasRole($rolesInput) //
    {
        $currentRole = $this->roles; //
        if (!$currentRole) {
            return false;
        }

        if (is_array($rolesInput)) {
            return in_array($currentRole->name, $rolesInput); // So sánh theo tên vai trò
        }
        return $currentRole->name === $rolesInput; // So sánh theo tên vai trò
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


    public function hasPermissionToCustom(string $permissionName): bool
    {
        Log::info("User::hasPermissionToCustom - Checking permission: '{$permissionName}' for User ID: {$this->id}");

        // SỬA Ở ĐÂY: Truy cập đối tượng Role qua $this->roles (thuộc tính động tương ứng với phương thức roles())
        $currentRole = $this->roles; //

        if (!$currentRole) { // Kiểm tra xem $currentRole có null không
            Log::info("User::hasPermissionToCustom - User ID: {$this->id} has NO role assigned (this->roles is null). role_id is: " . $this->role_id);
            return false;
        }
        Log::info("User::hasPermissionToCustom - User ID: {$this->id} has Role ID: {$currentRole->id} (Name: {$currentRole->name})");

        $cacheKey = "role_{$currentRole->id}_permissions_list";

        $rolePermissions = Cache::rememberForever($cacheKey, function () use ($currentRole) { // Truyền $currentRole vào closure
            // Log::info("User::hasPermissionToCustom - Cache miss for '{$cacheKey}'. Fetching permissions from DB for Role ID: {$currentRole->id}");
            // Gọi phương thức permissions() trên đối tượng $currentRole
            $dbPerms = $currentRole->permissions()->pluck('custom_permissions.name')->all();
            Log::info("User::hasPermissionToCustom - Permissions from DB for Role ID {$currentRole->id}: " . implode(', ', $dbPerms ?: ['NONE']));
            return $dbPerms;
        });

        if (!is_array($rolePermissions)) {
            Log::error("User::hasPermissionToCustom - rolePermissions is not an array for cache key {$cacheKey}. Re-fetching from DB.");
            Cache::forget($cacheKey);
            $rolePermissions = $currentRole->permissions()->pluck('custom_permissions.name')->all();
            Cache::forever($cacheKey, $rolePermissions);
        }

        Log::info("User::hasPermissionToCustom - Permissions for Role ID {$currentRole->id} (from cache or fresh): " . implode(', ', $rolePermissions ?: ['NONE']));

        $hasPermission = in_array($permissionName, $rolePermissions);
        Log::info("User::hasPermissionToCustom - Permission '{$permissionName}' for User ID {$this->id}: " . ($hasPermission ? 'GRANTED' : 'DENIED'));
        return $hasPermission;
    }


    public function getAllPermissionNamesCustom(): array
    {
        // SỬA Ở ĐÂY: Truy cập đối tượng Role qua $this->roles
        $currentRole = $this->roles; //

        if (!$currentRole) {
            return [];
        }
        $cacheKey = "role_{$currentRole->id}_permissions_list"; // Nhất quán tên cache key
        return Cache::rememberForever($cacheKey, function () use ($currentRole) { // Truyền $currentRole vào closure
            // Gọi phương thức permissions() trên đối tượng $currentRole
            return $currentRole->permissions()->pluck('custom_permissions.name')->all();
        });
    }



    public function counpons()
    {
        return $this->belongsToMany(Counpon::class, 'coupon_user', 'user_id', 'coupon_id');
    }

}
