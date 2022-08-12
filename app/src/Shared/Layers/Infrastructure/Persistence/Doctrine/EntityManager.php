<?php

namespace Finconsult\Documentor\Shared\Layers\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Doctrine\ORM\EntityManagerInterface as DoctrineEntityManager;

class EntityManager extends EntityManagerDecorator implements EntityManagerInterface
{
    /** @var DoctrineEntityManager */
    protected $wrapped;

    public function markToSave(object $entity)
    {
        $this->wrapped->persist($entity);
    }

    public function save(object $entity): void
    {
        $this->wrapped->persist($entity);
        $this->wrapped->flush();
    }

    public function markToBatchSave(object ...$entities): void
    {
        foreach ($entities as $entity) {
            $this->wrapped->persist($entity);
        }
    }

    public function batchSave(object ...$entities): void
    {
        foreach ($entities as $entity) {
            $this->wrapped->persist($entity);
        }

        $this->wrapped->flush();
    }

    public function markToDelete(object $entity)
    {
        $this->remove($entity);
    }

    public function delete(object $entity): void
    {
        $this->wrapped->remove($entity);
        $this->wrapped->flush();
    }

    public function markToBatchDelete(object ...$entities): void
    {
        foreach ($entities as $entity) {
            $this->wrapped->remove($entity);
        }
    }

    public function batchDelete(object ...$entities): void
    {
        foreach ($entities as $entity) {
            $this->wrapped->remove($entity);
        }

        $this->wrapped->flush();
    }
}
