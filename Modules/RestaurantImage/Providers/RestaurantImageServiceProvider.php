<?php namespace Modules\RestaurantImage\Providers;

use Illuminate\Support\ServiceProvider;

class RestaurantImageServiceProvider extends ServiceProvider
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
            'Modules\RestaurantImage\Repositories\RestaurantImageRepository',
            function () {
                $repository = new \Modules\RestaurantImage\Repositories\Eloquent\EloquentRestaurantImageRepository(new \Modules\RestaurantImage\Entities\RestaurantImage());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\RestaurantImage\Repositories\Cache\CacheRestaurantImageDecorator($repository);
            }
        );
// add bindings

    }
}
