<?php namespace Telenok\News\Event;

class Listener {

    public function onRepositoryPackage($event) {}

    public function subscribe($events)
    {
        $events->listen(
            'App\Telenok\Core\Event\RepositoryPackage',
            'App\Telenok\News\Event\Listener@onRepositoryPackage'
        );
    }
}
