<?php

    app()->register('App\Vendor\Telenok\News\NewsServiceProvider');
    app('events')->subscribe('App\Vendor\Telenok\News\Event\Listener');

    if (app('\App\Vendor\Telenok\Core\Support\Install\Controller')->isTelenokInstalled())
    {
        $this->line('Package migrating', true);

        $this->call('migrate', [
            '--path' => 'vendor/telenok/news/src/migrations',
            '--force' => true
        ]);
    }
