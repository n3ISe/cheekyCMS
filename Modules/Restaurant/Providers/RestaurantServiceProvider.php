<?php namespace Modules\Restaurant\Providers;

use Illuminate\Support\ServiceProvider;

class RestaurantServiceProvider extends ServiceProvider
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
            'Modules\Restaurant\Repositories\RestaurantRepository',
            function () {
                $repository = new \Modules\Restaurant\Repositories\Eloquent\EloquentRestaurantRepository(new \Modules\Restaurant\Entities\Restaurant());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Restaurant\Repositories\Cache\CacheRestaurantDecorator($repository);
            }
        );
// add bindings

    }
}
