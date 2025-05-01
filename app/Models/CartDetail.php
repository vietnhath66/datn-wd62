<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'price',
        'status'

    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
