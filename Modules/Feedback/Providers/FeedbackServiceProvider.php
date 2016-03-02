<?php namespace Modules\Feedback\Providers;

use Illuminate\Support\ServiceProvider;

class FeedbackServiceProvider extends ServiceProvider
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
            'Modules\Feedback\Repositories\FeedbackRepository',
            function () {
                $repository = new \Modules\Feedback\Repositories\Eloquent\EloquentFeedbackRepository(new \Modules\Feedback\Entities\Feedback());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Feedback\Repositories\Cache\CacheFeedbackDecorator($repository);
            }
        );
// add bindings

    }
}
