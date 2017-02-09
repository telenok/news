<?php

    app()->register('App\Vendor\Telenok\News\NewsServiceProvider');

    app('events')->subscribe('App\Vendor\Telenok\News\Event\Subscribe');

    if (app('\App\Vendor\Telenok\Core\Support\Install\Controller')->telenokInstalled())
    {
        $this->line('Package migrating', true);

        $this->call('migrate', [
            '--path' => 'vendor/telenok/news/src/migrations',
            '--force' => true
        ]);
    }
