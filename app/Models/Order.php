<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'admin_confirmer_id',
        'shipper_id',
        'email',
        'phone',
        'total',
        'coupon',
        'barcode',
        'status',
        'shop_confirmed_at',
        'note',
        'payment_status',
        'accepted_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'refunded_at',
        'failed_at',
        'address',
        'number_house',
        'neighborhood',
        'district',
        'province',
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


    public function shipper(): BelongsTo
    {

        return $this->belongsTo(User::class, 'shipper_id');
    }


    public function confirmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_confirmer_id');
    }


    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'accepted_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'refunded_at' => 'datetime',
        'failed_at' => 'datetime',
        'shop_confirmed_at' => 'datetime', // <-- Cast timestamp mới
        'total' => 'decimal:2', // Ví dụ cast tiền tệ
        'attribute' => 'json',
    ];
}
