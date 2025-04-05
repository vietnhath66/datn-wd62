<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Traits\QueryScopes;

class Product extends Model
{

    use HasFactory, SoftDeletes, QueryScopes;


    protected $fillable = [
        'name',
        'product_catalogue_id',
        'brand_id',
        'image',
        'price',
        'description',
        'content',
        'publish',
        'is_sale',
        'is_new',
        'is_trending',
        'is_show_home',
    ];

    protected $table = 'products';

    public function product_catalogues()
    {
        return $this->belongsToMany(ProductCatalogue::class, 'product_catalogue_product', 'product_id', 'product_catalogue_id');
    }

    public function product_variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    protected $casts = [
        'attribute' => 'json',
    ];

}

