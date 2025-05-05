<?php

namespace App\Providers;

use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface;
use App\Repositories\ProductCatalogueRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\ReviewRepository;
use App\Services\Interfaces\ReviewServiceInterface;
use App\Services\ReviewService;

class ReponsitoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * 
     * 
     */

    public $bindings = [
        'App\Repositories\Interfaces\BrandRepositoryInterface' => 'App\Repositories\BrandRepository',
        'App\Repositories\Interfaces\ProductCatalogueRepositoryInterface' => 'App\Repositories\ProductCatalogueRepository',

    ];

    public function register(): void
    {
        foreach ($this->bindings as $key => $val) {
            $this->app->bind($key, $val);
        }
        $this->app->bind(ProductCatalogueRepositoryInterface::class, ProductCatalogueRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(ReviewServiceInterface::class, ReviewService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
