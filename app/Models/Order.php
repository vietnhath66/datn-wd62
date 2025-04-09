<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'email',
        'phone',
        'total',
        'status',
        'payment_status',
        'address',
        'number_house',
        'neighborhood',
        'district',
        'province',
        'coupon',
        'barcode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function items()
    {
        return $this->hasMany(OrderDetail::class);
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    protected $casts = [
        'attribute' => 'json',
    ];
}
