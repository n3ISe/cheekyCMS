<?php namespace Modules\ApiUser\Providers;

use Illuminate\Support\ServiceProvider;

class ApiUserServiceProvider extends ServiceProvider
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
            'Modules\ApiUser\Repositories\ApiUserRepository',
            function () {
                $repository = new \Modules\ApiUser\Repositories\Eloquent\EloquentApiUserRepository(new \Modules\ApiUser\Entities\ApiUser());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\ApiUser\Repositories\Cache\CacheApiUserDecorator($repository);
            }
        );
// add bindings

    }
}
