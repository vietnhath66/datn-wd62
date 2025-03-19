<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'name',
        'product_id',
        'code',
        'quantity',
        'sku',
        'price',
        'publish',
    ];


    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class, 'product_variant_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_variant_attribute', 'product_variant_id', 'attribute_id');
    }

}
