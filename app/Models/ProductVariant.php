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
        'name_variant_size',
        'name_variant_color',
        'product_id ',
        'code',
        'quantity',
        'sku',
        'price',
        'publish',
        'deleted_at',
        'created_at',
        'updated_at',
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


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributess()
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
