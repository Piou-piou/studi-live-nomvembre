<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

//#[AsEventListener(event: RequestEvent::class, method: 'dumpInformation', priority: -10)]
//#[AsEventListener(event: RequestEvent::class, method: 'debugRequest', priority: 255)]
class RequestListener
{
    public function dumpInformation(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $route = $event->getRequest()->get('_route');

        if (str_starts_with($route, 'admin_')) {
            dump('hello admin');
        } else {
            //throw new AccessDeniedException('Not authorized');
        }
    }

    public function debugRequest(RequestEvent $event): void
    {
        dump($event->getRequest());
    }
}
