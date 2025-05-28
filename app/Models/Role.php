<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $table = 'roles';
    protected $primaryKey = 'id';
    public function permissions()
    {
        return $this->belongsToMany(CustomPermission::class, 'custom_role_has_permissions', 'role_id', 'permission_id');
    }

    public function users()
    {
        // Một vai trò có nhiều người dùng (qua cột role_id trong bảng users)
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
