<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPermission extends Model
{
    use HasFactory;

    protected $table = 'custom_permissions';
    protected $fillable = ['name', 'description'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'custom_role_has_permissions', 'permission_id', 'role_id');
    }
}
