<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeCatalogue extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'content',
        'image',
    ];

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'attribute_catalogue_id');
    }
}
