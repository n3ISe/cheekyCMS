<?php namespace Modules\ImageDimension\Providers;

use Illuminate\Support\ServiceProvider;

class ImageDimensionServiceProvider extends ServiceProvider
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
            'Modules\ImageDimension\Repositories\ImageDimensionRepository',
            function () {
                $repository = new \Modules\ImageDimension\Repositories\Eloquent\EloquentImageDimensionRepository(new \Modules\ImageDimension\Entities\ImageDimension());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\ImageDimension\Repositories\Cache\CacheImageDimensionDecorator($repository);
            }
        );
// add bindings

    }
}
