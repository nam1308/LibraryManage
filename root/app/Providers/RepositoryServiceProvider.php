<?php

namespace App\Providers;

use App\Repositories\Contracts\AdminRepository;
use App\Repositories\Contracts\BorrowerRepository;
use App\Repositories\Eloquent\BorrowerRepositoryEloquent;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\BookRepository;
use App\Repositories\Eloquent\BookRepositoryEloquent;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use App\Repositories\Contracts\NotificationRepository;
use App\Repositories\Contracts\ReflectionRepository;
use App\Repositories\Eloquent\AdminRepositoryEloquent;
use App\Repositories\Eloquent\NotificationRepositoryEloquent;
use App\Repositories\Eloquent\ReflectionRepositoryEloquent;
use App\Repositories\Contracts\UserBookRepository;
use App\Repositories\Eloquent\UserBookRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            \App\Repositories\Contracts\ExampleRepository::class,
            \App\Repositories\Eloquent\ExampleRepositoryEloquent::class
        );
        $this->app->bind(\App\Repositories\Contracts\UserRepository::class, \App\Repositories\Eloquent\UserRepositoryEloquent::class);
        $this->app->bind(BorrowerRepository::class, BorrowerRepositoryEloquent::class);
        $this->app->bind(BookRepository::class, BookRepositoryEloquent::class);
        $this->app->bind(CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->app->bind(NotificationRepository::class, NotificationRepositoryEloquent::class);
        $this->app->bind(ReflectionRepository::class, ReflectionRepositoryEloquent::class);
        $this->app->bind(AdminRepository::class, AdminRepositoryEloquent::class);
        $this->app->bind(UserBookRepository::class, UserBookRepositoryEloquent::class);
        //:end-bindings:
    }
}