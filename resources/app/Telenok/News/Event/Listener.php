<?php namespace App\Vendor\Telenok\News\Event;

class Listener extends \Telenok\News\Event\Listener {


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
