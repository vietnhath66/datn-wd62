<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantAttribute extends Model
{
    use HasFactory;

    protected $table = 'product_variant_attribute';

    protected $fillable = [
        'product_variant_id',
        'attribute_id',
    ];


    public function productVariants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attribute', 'attribute_id', 'product_variant_id')
            ->withPivot(['value'])
            ->withTimestamps();
    }
}
