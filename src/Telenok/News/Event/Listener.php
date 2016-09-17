<?php namespace Telenok\News\Event;

use Telenok\Core\Event\RepositoryPackage;

class Listener {

    public function onRepositoryPackage(RepositoryPackage $event)
    {
        $event->getList()->push('Telenok\News\PackageInfo');
    }

    public function subscribe($events)
    {
        $this->addListenerRepositoryPackage($events);
    }

    public function addListenerRepositoryPackage($events)
    {
        $events->listen(
            'Telenok\Core\Event\RepositoryPackage',
            'App\Vendor\Telenok\News\Event\Listener@onRepositoryPackage'
        );
    }
}
