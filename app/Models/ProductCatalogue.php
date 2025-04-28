<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Traits\QueryScopes;

class ProductCatalogue extends Model
{
    protected $fillable = ['title', 'parent_id', 'image'];

    public function children()
    {
        return $this->hasMany(ProductCatalogue::class, 'parent_id')->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCatalogue::class, 'parent_id');
    }

}
