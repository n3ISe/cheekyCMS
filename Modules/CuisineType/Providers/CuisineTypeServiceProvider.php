<?php namespace Modules\CuisineType\Providers;

use Illuminate\Support\ServiceProvider;

class CuisineTypeServiceProvider extends ServiceProvider
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
            'Modules\CuisineType\Repositories\CuisineTypeRepository',
            function () {
                $repository = new \Modules\CuisineType\Repositories\Eloquent\EloquentCuisineTypeRepository(new \Modules\CuisineType\Entities\CuisineType());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\CuisineType\Repositories\Cache\CacheCuisineTypeDecorator($repository);
            }
        );
// add bindings

    }
}
