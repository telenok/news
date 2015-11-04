<?php namespace Telenok\News;

use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/../../view'), 'news');
        $this->loadTranslationsFrom(realpath(__DIR__ . '/../../lang'), 'news');

        $this->publishes([realpath(__DIR__ . '/../../../resources/app') => app_path('packages/telenok/news')], 'resources-app');
    }

    public function provides()
    {
        return [];
    }

    public function register()
    {
    }
}