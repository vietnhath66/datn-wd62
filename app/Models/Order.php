<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Models\OrderItem;
use App\Traits\QueryScopes;

class Order extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'id',
        'user_id',
        'email',
        'total',
        'phone',
        'status',
        'barcode',
        'province',
        'district',
        'number_house',
        'address',
        'coupon',
        'payment_status',
        'neighborhood',
        'created_at',
        'updated_at'


    ];

    protected $table = 'orders';

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    protected $casts = [
        'attribute' => 'json',
    ];
}
