<?php namespace Modules\Menus\Providers;

use Illuminate\Support\ServiceProvider;

class MenusServiceProvider extends ServiceProvider
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
            'Modules\Menus\Repositories\MenusRepository',
            function () {
                $repository = new \Modules\Menus\Repositories\Eloquent\EloquentMenusRepository(new \Modules\Menus\Entities\Menus());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Menus\Repositories\Cache\CacheMenusDecorator($repository);
            }
        );
// add bindings

    }
}
