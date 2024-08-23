<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Models\CategoryBusiness;
use App\Repositories\Interface\FileUploadInterface;
use App\Repositories\Interface\ProductInterface;
use App\Repositories\ProductRepository;
use App\Repositories\FileUploadRepository;
use App\Repositories\Interface\NumberingInterface;
use App\Repositories\Interface\PurchaseInterface;
use App\Repositories\NumberingRepository;
use App\Repositories\PurchaseRepository;
use App\Services\ProductService;
use App\Services\FileUploadService;
use App\Services\NumberingService;
use App\Services\PurchaseService;

//Interface
use App\Repositories\Interface\WarehouseInte\BeginningBalanceInterface;

//Repository
use App\Repositories\WarehouseRepo\BeginningBalanceRepository;

//Service
use App\Services\Warehouse\BeginningBalanceService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);

        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductInterface::class));
        });

        $this->app->bind(FileUploadInterface::class, FileUploadRepository::class);
        $this->app->bind(FileUploadService::class, function ($app) {
            return new FileUploadService($app->make(FileUploadInterface::class));
        });

        $this->app->bind(NumberingInterface::class, NumberingRepository::class);
        $this->app->bind(NumberingService::class, function ($app) {
            return new NumberingService($app->make(NumberingInterface::class));
        });

        $this->app->bind(PurchaseInterface::class, PurchaseRepository::class);
        $this->app->bind(PurchaseService::class, function ($app) {
            return new PurchaseService($app->make(PurchaseInterface::class));
        });

        $this->app->bind(BeginningBalanceInterface::class, BeginningBalanceRepository::class);
        $this->app->bind(BeginningBalanceService::class, function ($app) {
            return new BeginningBalanceService($app->make(BeginningBalanceInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $categories_business = CategoryBusiness::where('publish', 1)->orderBy('sort', 'DESC')->get();
        view()->share('categories_business', $categories_business);
    }
}
