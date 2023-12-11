<?php

namespace App\Logger;

use App\Entity\Logger;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

#[AsDoctrineListener(Events::postPersist)]
#[AsDoctrineListener(Events::postUpdate)]
#[AsDoctrineListener(Events::preRemove)]
class LoggerListener
{
    public function __construct(private readonly EntityManagerInterface $em, private Security $security,) {}

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->updateLogger($args->getObject(), Logger::CREATED);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->updateLogger($args->getObject(), Logger::UPDATED);
    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $this->updateLogger($args->getObject(), Logger::DELETED);
    }

    private function updateLogger($entity, string $type): void
    {
        if (Logger::class === $entity::class) {
            return;
        }

        $entity_values = $this->getEntityValues($entity, $type);

        $logger = new Logger();
        $logger->setEntityName($entity::class);
        $logger->setEntityId($entity->getId());
        $logger->setUpdatedType($type);
        $logger->setUpdatedBy($this->security->getUser());

        if (Logger::DELETED !== $type) {
            if (Logger::CREATED !== $type) {
                $logger->setPreviousData($entity_values['previous'] ?? []);
            }
            $logger->setCurrentData($entity_values['current'] ?? []);
        }

        if (Logger::CREATED === $type) {
            $logger->setCreatedBy($this->security->getUser());
        }

        $this->em->persist($logger);
        $this->em->flush();
    }

    private function getEntityValues($entity, string $type): array
    {
        $return_values = [];

        foreach ($this->em->getUnitOfWork()->getEntityChangeSet($entity) as $field_name => $values) {
            $return_values['previous'][$field_name] = $values[0];
            $return_values['current'][$field_name] = $values[1];
        }

        return $return_values;
    }
}
