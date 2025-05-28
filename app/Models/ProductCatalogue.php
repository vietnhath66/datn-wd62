<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Traits\QueryScopes;
use Kalnoy\Nestedset\NodeTrait;

class ProductCatalogue extends Model
{
    // use HasFactory, QueryScopes, NodeTrait;
    use HasFactory, QueryScopes;


    protected $fillable = [
        'image',
        'name',
        'content',
        'description',
        'parent_id',
        'lft',
        'rgt',
        'level',
        'publish'
    ];

    protected $table = 'product_catalogues';
    protected $casts = [
        'attribute' => 'json'
    ];


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


    public function getParentIdName()
    {
        return 'parent_id';
    }

    public function getLftName()
    {
        return 'lft';
    }

    public function getRgtName()
    {
        return 'rgt';
    }



}
