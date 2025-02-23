<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\BrandRepositoryInterface;
use App\Repositories\BrandRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\Interfaces\DistrictRepositoryInterface;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface;
use App\Repositories\Interfaces\ProvinceReponsitoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WardRepositoryInterface;
use App\Repositories\ProductCatalogueRepository;
use App\Repositories\ProvinceReponsitory;
use App\Repositories\RoleReponsitory;
use App\Repositories\UserRepository;
use App\Repositories\WardRepository;
use App\Services\Interfaces\BrandServiceInterface;
use App\Services\BrandService;
use App\Services\Interfaces\ProductCatalogueServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\ProductCatalogueService;
use App\Services\RoleService;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $serviceBindings = [
        'App\Services\Interfaces\BrandServiceInterface' => 'App\Services\BrandService',
        'App\Services\Interfaces\ProductCatalogueServiceInterface' => 'App\Services\ProductCatalogueService',
    ];

    public function register(): void
    {
        // foreach ($this->serviceBindings as $key => $value) {
        //     $this->app->bind($key, $value);
        // }
        // $this->app->register(ReponsitoryServiceProvider::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(BrandServiceInterface::class, BrandService::class);
        $this->app->bind(ProductCatalogueRepositoryInterface::class, ProductCatalogueRepository::class);
        $this->app->bind(ProductCatalogueServiceInterface::class, ProductCatalogueService::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleReponsitory::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(DistrictRepositoryInterface::class, DistrictRepository::class);
        $this->app->bind(ProvinceReponsitoryInterface::class, ProvinceReponsitory::class);
        $this->app->bind(WardRepositoryInterface::class, WardRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
