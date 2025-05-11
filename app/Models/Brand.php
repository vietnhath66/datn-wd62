<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    protected $table = 'brands';

    // public function products(){
    //     return $this->belongsToMany(Product::class, 'product_catalogue_product' , 'product_catalogue_id', 'product_id')->withPivot(
    //         'product_catalogue_id',
    //         'product_id',
    //     );
    // }
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}
