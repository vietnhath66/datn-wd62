<?php

namespace App\Providers;

use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface;
use App\Repositories\ProductCatalogueRepository;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
