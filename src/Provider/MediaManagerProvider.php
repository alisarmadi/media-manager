<?php

namespace Blytd\MediaManager\Provider;

use Blytd\MediaManager\Repository\Contract\MediaRepositoryInterface;
use Blytd\MediaManager\Repository\MongoDB\MediaRepository;
use Illuminate\Support\ServiceProvider;

class MediaManagerProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(MediaRepositoryInterface::class, MediaRepository::class);
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
