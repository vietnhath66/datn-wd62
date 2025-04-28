<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Services\RoleService;
use App\Services\UserService;
use App\Services\BrandService;
use App\Models\ProductCatalogue;
use App\Services\ProductService;
use App\Services\AttributeService;
use App\Repositories\UserRepository;
use App\Repositories\WardRepository;
use App\Repositories\BrandRepository;
use App\Repositories\RoleReponsitory;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\DistrictRepository;
use App\Repositories\ProvinceReponsitory;
use App\Services\ProductCatalogueService;
use App\Repositories\AttributeReponsitory;
use App\Services\AttributeCatalogueService;
use App\Repositories\ProductCatalogueRepository;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\BrandServiceInterface;
use App\Repositories\AttributeCatalogueReponsitory;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\AttributeServiceInterface;
use App\Repositories\ProductVariantAttributeRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WardRepositoryInterface;
use App\Repositories\Interfaces\BrandRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\DistrictRepositoryInterface;
use App\Repositories\Interfaces\ProvinceReponsitoryInterface;
use App\Services\Interfaces\ProductCatalogueServiceInterface;
use App\Repositories\Interfaces\AttributeReponsitoryInterface;
use App\Services\Interfaces\AttributeCatalogueServiceInterface;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface;
use App\Repositories\Interfaces\AttributeCatalogueReponsitoryInterface;
use App\Repositories\Interfaces\ProductVariantAttributeReponsitoryInterface;

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
        $this->app->bind(AttributeReponsitoryInterface::class, AttributeReponsitory::class);
        $this->app->bind(AttributeCatalogueReponsitoryInterface::class, AttributeCatalogueReponsitory::class);
        $this->app->bind(AttributeServiceInterface::class, AttributeService::class);
        $this->app->bind(AttributeCatalogueServiceInterface::class, AttributeCatalogueService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductVariantAttributeReponsitoryInterface::class, ProductVariantAttributeRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    $catalogues = ProductCatalogue::whereNull('parent_id')
        ->with('children')
        ->get();

    View::share('catalogues', $catalogues);
}
}
