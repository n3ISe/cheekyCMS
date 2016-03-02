<?php namespace Modules\Tag\Providers;

use Illuminate\Support\ServiceProvider;

class TagServiceProvider extends ServiceProvider
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
            'Modules\Tag\Repositories\TagRepository',
            function () {
                $repository = new \Modules\Tag\Repositories\Eloquent\EloquentTagRepository(new \Modules\Tag\Entities\Tag());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Tag\Repositories\Cache\CacheTagDecorator($repository);
            }
        );
// add bindings

    }
}
