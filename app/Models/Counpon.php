<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counpon extends Model
{
    use HasFactory;

    protected $table = 'counpon_user';

    protected $fillable = [
        'name',
        'code',
        'discount_type',
        'discount_value',
        'number',
        'minimum_order_amount',
        'start_date',
        'end_date',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'counpon_user', 'coupon_id', 'user_id');
    }
}
