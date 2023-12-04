<?php

namespace App\EventSubscriber;

use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
            ConsoleEvents::ERROR => 'onConsoleException',
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {

        /*if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], '.local')) {
            return;
        }*/
        if (HttpKernelInterface::MAIN_REQUEST !== $event->getRequestType() || !$event->getRequestType()) {
            return;
        }

        // to do implements system error sending to Sentry, slack, teams or other
        $message = $event->getThrowable()->getFile() . ' à la ligne '.$event->getThrowable()->getLine();
        $message .= '\n URL: '.$event->getRequest()->getUri();
//        $message .= 'Utilisateur: '.$this->user->getUsername();

        // for sentry : https://docs.sentry.io/platforms/php/?original_referrer=https%3A%2F%2Fsentry.io%2F
        /*\Sentry\init(['dsn' => 'https://examplePublicKey@o0.ingest.sentry.io/0' ]);
        \Sentry\captureException($event->getThrowable());*/

        dump($message);
    }

    public function onConsoleException(ConsoleErrorEvent $event)
    {
        $message = $event->getCommand()->getName(). ' \n';
        $message .= 'erreur: '. $event->getError();

        dump($message);
    }
}
