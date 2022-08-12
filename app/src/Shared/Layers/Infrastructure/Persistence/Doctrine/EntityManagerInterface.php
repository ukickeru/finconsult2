<?php

namespace Finconsult\Documentor\Shared\Layers\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface as DoctrineEntityManagerInterface;

interface EntityManagerInterface extends DoctrineEntityManagerInterface, EntityBatchHandlerInterface
{
    /**
     * Помечает сущность для сохранения, аналогично EntityManager->persist().
     */
    public function markToSave(object $entity);

    /**
     * Сохраняет сущность.
     */
    public function save(object $entity);

    /**
     * Помечает сущность для удаления, аналогично EntityManager->remove().
     */
    public function markToDelete(object $entity);

    /**
     * Удаляет сущность.
     */
    public function delete(object $entity);
}
