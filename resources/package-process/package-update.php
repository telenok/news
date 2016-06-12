<?php

    app()->register('Telenok\News\NewsServiceProvider');

    $this->line('Examine app.php');

    $this->call('telenok:package', [
        'action' => 'add-provider', 
        '--provider' => 'Telenok\News\NewsServiceProvider',
    ]);   

    $this->line('Package new classes copy');

    $this->call('vendor:publish', [
        '--tag' => ['resourcesapp'], 
        '--provider' => 'Telenok\News\NewsServiceProvider',
    ]);
    
    $this->line('Package migrating', true);

    $this->call('migrate', [
        '--path' => 'vendor/telenok/news/src/migrations', 
        '--force' => true
    ]);