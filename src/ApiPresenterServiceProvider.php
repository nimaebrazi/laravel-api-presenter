<?php


namespace LaravelApiPresenter;


use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\ServiceProvider;
use LaravelApiPresenter\Contract\ApiPresenterInterface;
use LaravelApiPresenter\Contract\ResponseFactory;
use LaravelApiPresenter\Contract\ResponseInterface;
use LaravelApiPresenter\Factory\JsonResponseFactory;
use LaravelApiPresenter\Presenter\JsonApiPresenter;
use LaravelApiPresenter\Presenter\Response;

class ApiPresenterServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ResponseInterface::class, function () {
            return new Response();
        });


        $this->registerJsonImplementation();
    }

    protected function registerJsonImplementation()
    {
        $this->app->singleton(ResponseFactory::class, function () {
            return new JsonResponseFactory();
        });

        $this->app->bind(ApiPresenterInterface::class, function () {

            return new JsonApiPresenter(
                $this->app->make(ResponseInterface::class),
                $this->app->make(ResponseFactory::class),
                $this->app->make(CacheRepository::class)
            );

        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            ResponseFactory::class,
            ResponseInterface::class,
            ApiPresenterInterface::class,
        ];
    }
}