<?php namespace Telenok\News\Event;

class Listener {

    public function onRepositoryPackage($event) {}

    public function subscribe($events)
    {
        $events->listen(
            'Telenok\Core\Event\RepositoryPackage',
            'App\Vendor\Telenok\News\Event\Listener@onRepositoryPackage'
        );
    }
}
