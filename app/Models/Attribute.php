<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Traits\QueryScopes;

class Attribute extends Model
{

    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'image',
        'name',
        'content',
        'description',
        'attribute_catalogue_id',
    ];
    protected $table = 'attributes';
    public function attribute_catalogues()
    {
        return $this->belongsToMany(AttributeCatalogue::class, 'attribute_catalogue_attribute', 'attribute_id', 'attribute_catalogue_id');
    }

    public function catalogue()
    {
        return $this->belongsTo(AttributeCatalogue::class, 'attribute_catalogue_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attributes', 'attribute_id', 'product_id');
    }
}
