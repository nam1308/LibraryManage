<?php

namespace App\Providers;

use App\Services\Api\AdminService;
use App\Services\Api\BorrowerService;
use App\Services\Api\ExamplesService;
use App\Services\Api\UserService;
use App\Services\Api\BookService;
use App\Services\Api\CategoryService;
use App\Services\Contracts\BorrowerServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\ExamplesServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Contracts\BookServiceInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\NotificationServiceInterface;
use App\Services\Api\NotificationService;
use App\Services\Api\ReflectionService;
use App\Services\Contracts\ReflectionServiceInterface;
use App\Services\Contracts\AdminServiceInterface;

class ServiceServiceProvider extends ServiceProvider
{
    protected $services = [
        ExamplesServiceInterface::class => ExamplesService::class,
        UserServiceInterface::class => UserService::class,
        BorrowerServiceInterface::class => BorrowerService::class,
        BookServiceInterface::class => BookService::class,
        CategoryServiceInterface::class => CategoryService::class,
        NotificationServiceInterface::class => NotificationService::class,
        ReflectionServiceInterface::class => ReflectionService::class,
        AdminServiceInterface::class => AdminService::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->services as $interface => $class) {
            $this->app->singleton($interface, $class);
        }
    }
}
