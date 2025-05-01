<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'name', 'code', 'discount_type', 'discount_value', 'number',
        'minimum_order_amount', 'start_date', 'end_date'
    ];
    protected $dates = ['start_date', 'end_date'];
}
