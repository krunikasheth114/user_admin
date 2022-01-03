<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\BaseContract;
use App\Contracts\ProductContract;
use App\Repositories\ProductRepository;
use App\Repositories\BaseRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductContract::class,ProductRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
