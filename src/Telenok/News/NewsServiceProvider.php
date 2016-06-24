<?php namespace Telenok\News;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class NewsServiceProvider extends ServiceProvider {

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

    public function register()
    {
    }
}