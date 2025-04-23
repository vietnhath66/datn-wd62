<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $fillable = [
        'product_id', 'name', 'name_variant_size', 'name_variant_color',
        'code', 'quantity', 'sku', 'price', 'publish'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes()
{
    return $this->belongsToMany(Attribute::class, 'attribute_product_variant', 'variant_id', 'attribute_id');
}

public function size()
{
    return $this->belongsTo(Attribute::class, 'size_id');
}

public function color()
{
    return $this->belongsTo(Attribute::class, 'color_id');
}
}
