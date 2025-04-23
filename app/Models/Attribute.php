<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'attribute_catalogue_id', 'image', 'name', 'description', 'content'
    ];

    public function catalogue()
    {
        return $this->belongsTo(AttributeCatalogue::class, 'attribute_catalogue_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attributes', 'attribute_id', 'product_id');
    }
}
