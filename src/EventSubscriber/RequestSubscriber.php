<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['dumpInformation', 10],
                ['debugRequest', 10],
            ]
        ];
    }

    public function dumpInformation(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $route = $event->getRequest()->get('_route');

        if (str_starts_with($route, 'admin_')) {
            //dump('hello admin');
        } else {
            //throw new AccessDeniedException('Not authorized');
        }
    }

    public function debugRequest(RequestEvent $event): void
    {
       // dump($event->getRequest());
    }
}
