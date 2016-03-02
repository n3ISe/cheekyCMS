<?php namespace Modules\ReportReason\Providers;

use Illuminate\Support\ServiceProvider;

class ReportReasonServiceProvider extends ServiceProvider
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
            'Modules\ReportReason\Repositories\ReportReasonRepository',
            function () {
                $repository = new \Modules\ReportReason\Repositories\Eloquent\EloquentReportReasonRepository(new \Modules\ReportReason\Entities\ReportReason());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\ReportReason\Repositories\Cache\CacheReportReasonDecorator($repository);
            }
        );
// add bindings

    }
}
