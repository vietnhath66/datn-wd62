<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'deleted_at',
        'is_trending',
        'is_show_home',
        'attributeCatalogue',
        'attribute',
        'variant',
        'view',
    ];

    protected $dates = ['deleted_at'];

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

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes', 'product_id', 'attribute_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }


    // public function reviews() {
    //     return $this->morphMany(Review::class, 'reviewable');
    // }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function getAverageRatingAttribute()
    {
        return (float) $this->reviews()->avg('rating') ?? 0;
    }
    public function galleries()
    {
        //Product belong to catalogues
        return $this->hasMany(ProductGallery::class);
    }


    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }


    public function wishingUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'product_id', 'user_id')->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        // Sự kiện này được gọi SAU KHI một model đã bị xóa (cả soft delete và force delete)
        static::deleted(function ($product) {
            // Chỉ xóa file vật lý nếu đây là FORCE DELETE
            if ($product->isForceDeleting()) {
                Log::info("Force deleting product ID: {$product->id}. Attempting to delete image: {$product->image}");
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                    Log::info("Successfully deleted image: {$product->image} for product ID: {$product->id}");
                }

                // Nếu bạn có gallery ảnh và muốn xóa file khi force delete product
                // $product->gallery()->withTrashed()->get()->each(function ($galleryImage) {
                //     if ($galleryImage->image_path && Storage::disk('public')->exists($galleryImage->image_path)) {
                //         Storage::disk('public')->delete($galleryImage->image_path);
                //     }
                //     $galleryImage->forceDelete(); // Xóa bản ghi gallery
                // });

                // Nếu product_variants có ảnh riêng và cần xóa file khi product cha bị force delete
                // $product->variants()->withTrashed()->get()->each(function ($variant) {
                //      if ($variant->image_variant_path && Storage::disk('public')->exists($variant->image_variant_path)) {
                //          Storage::disk('public')->delete($variant->image_variant_path);
                //      }
                //      // $variant->forceDelete(); // Dòng này có thể không cần nếu có ON DELETE CASCADE
                // });
            }
        });
    }

}

