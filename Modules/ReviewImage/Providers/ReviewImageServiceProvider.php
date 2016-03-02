<?php namespace Modules\ReviewImage\Providers;

use Illuminate\Support\ServiceProvider;

class ReviewImageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\ReviewImage\Repositories\ReviewImageRepository',
            function () {
                $repository = new \Modules\ReviewImage\Repositories\Eloquent\EloquentReviewImageRepository(new \Modules\ReviewImage\Entities\ReviewImage());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\ReviewImage\Repositories\Cache\CacheReviewImageDecorator($repository);
            }
        );
// add bindings

    }
}
