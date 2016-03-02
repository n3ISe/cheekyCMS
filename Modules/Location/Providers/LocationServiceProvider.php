<?php namespace Modules\Location\Providers;

use Illuminate\Support\ServiceProvider;

class LocationServiceProvider extends ServiceProvider
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
            'Modules\Location\Repositories\LocationRepository',
            function () {
                $repository = new \Modules\Location\Repositories\Eloquent\EloquentLocationRepository(new \Modules\Location\Entities\Location());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Location\Repositories\Cache\CacheLocationDecorator($repository);
            }
        );
// add bindings

    }
}
