<?php namespace Telenok\News;

use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider {

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        include __DIR__ . '/../../config/event.php';
    }

    /**
     * @method boot
     * Load config, routers, create singletons and others.
     * @return {void}
     * @member Telenok.News.CoreServiceProvider
     */
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/../../view'), 'news');
        $this->loadTranslationsFrom(realpath(__DIR__ . '/../../lang'), 'news');

        $this->publishes([realpath(__DIR__ . '/../../../resources/app') => app_path()], 'resourcesapp');
        
        include __DIR__ . '/../../config/routes.php';
    }

    public function provides()
    {
        return [];
    }

    public function register()
    {
    }
}