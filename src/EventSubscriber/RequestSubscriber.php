<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{

    private string $route = '';

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['dumpInformation', 10],
                ['debugRequest', 10],
            ],
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function dumpInformation(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $this->route = $route = $event->getRequest()->get('_route');
        dump($route);

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

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        dump($this->route);
    }
}
