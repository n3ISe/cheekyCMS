<?php namespace Modules\Asset\Providers;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
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
            'Modules\Asset\Repositories\AssetRepository',
            function () {
                $repository = new \Modules\Asset\Repositories\Eloquent\EloquentAssetRepository(new \Modules\Asset\Entities\Asset());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Asset\Repositories\Cache\CacheAssetDecorator($repository);
            }
        );
// add bindings

    }
}
