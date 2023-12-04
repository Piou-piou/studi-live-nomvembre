<?php

namespace App\EventListener\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsDoctrineListener(Events::prePersist)]
#[AsDoctrineListener(Events::preUpdate)]
class CreatedUpdatedListener
{
    private ?UserInterface $user;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        if ($user = $tokenStorage->getToken()?->getUser()) {
            $this->user = $user;
        }
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!method_exists($entity, 'setCreatedAt')) {
            return;
        }

        $entity->setCreatedAt(new \DateTime());
        $entity->setUpdatedAt(new \DateTime());
        $entity->setCreatedBy($this->user);
        $entity->setUpdatedBy($this->user);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!method_exists($entity, 'setUpdatedAt')) {
            return;
        }

        $entity->setUpdatedAt(new \DateTime());

        if ($this->user) {
            $entity->setUpdatedBy($this->user);
        }
    }
}
