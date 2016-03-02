<?php namespace Modules\ReportPhoto\Providers;

use Illuminate\Support\ServiceProvider;

class ReportPhotoServiceProvider extends ServiceProvider
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
            'Modules\ReportPhoto\Repositories\ReportPhotoRepository',
            function () {
                $repository = new \Modules\ReportPhoto\Repositories\Eloquent\EloquentReportPhotoRepository(new \Modules\ReportPhoto\Entities\ReportPhoto());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\ReportPhoto\Repositories\Cache\CacheReportPhotoDecorator($repository);
            }
        );
// add bindings

    }
}
