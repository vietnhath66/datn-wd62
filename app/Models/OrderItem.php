<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, QueryScopes;

    protected $table = 'order_items';

    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'product_variant_id ',
        'quantity',
        'price',
        'craeted_at',
        'updated_at',
    ];


    public function products(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function orders(){
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product_variant(){
        return $this->belongsTo(Product::class, 'product_varian_id', 'id');
    }
    // public function attributes(){
    //     return $this->belongsToMany(Attribute::class, 'product_variant_attribute' , 'product_variant_id', 'attribute_id');
    // }

}
