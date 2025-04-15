<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipperProfile extends Model
{
    use HasFactory;

    protected $table = "shipper_profiles";

    protected $fillable = [
        'user_id',
        'vehicle_type',
        'date_of_birth',
        'license_plate',
        'status'
    ];
}
