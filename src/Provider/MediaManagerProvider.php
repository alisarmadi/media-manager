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

        $this->publishes([
            __DIR__.'../Http/Controller/MediaController.php' => app_path('Http/Controllers/MediaController.php'),
        ], 'blytd-media-controller');
    }
}
