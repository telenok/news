<?php

    app()->register('App\Vendor\Telenok\News\NewsServiceProvider');

    $this->line('Package migrating', true);

    $this->call('migrate', [
        '--path' => 'vendor/telenok/news/src/migrations', 
        '--force' => true
    ]);