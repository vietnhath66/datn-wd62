<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Traits\QueryScopes;

class ProductCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'image',
        'name',
        'content',
        'description',
        'parent_id',
        'lft',
        'rgt',
        'level',
    ];

    protected $table = 'product_catalogues';
    protected $casts = [
        'attribute' => 'json'
    ];
    // public function products(){
    //     return $this->belongsToMany(Product::class, 'product_catalogue_product' , 'product_catalogue_id', 'product_id')->withPivot(
    //         'product_catalogue_id',
    //         'product_id',
    //     );
    // }

    // public function product_catalogue_language(){
    //     return $this->hasMany(ProductCatalogueLanguage::class, 'product_catalogue_id', 'id')->where('language_id','=',1);
    // }

    public static function isNodeCheck($id = 0)
    {
        $productCatalogue = ProductCatalogue::find($id);
        dd($productCatalogue);
        if ($productCatalogue->rgt - $productCatalogue->lft !== 1) {
            return false;
        }

        return true;

    }

    public function children(): HasMany
    {
        return $this->hasMany(ProductCatalogue::class, 'parent_id', 'id');
    }


    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCatalogue::class, 'parent_id', 'id');
    }


}
