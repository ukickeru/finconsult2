<?php

namespace Finconsult\Documentor\Shared\Infrastructure\Persistence\Doctrine;

trait RepositoryTrait
{
    /**
     * @param object $entity entity object to persist
     *
     * @throws \DomainException in case of entity class was not match for declared
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(object $entity): void
    {
        if (!($entity instanceof $this->_entityName)) {
            throw new \DomainException(self::class . ' works only with "' . $this->_entityName . '" objects!');
        }

        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * @param object $entity entity object to update
     *
     * @throws \DomainException in case of entity class was not match for declared
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(object $entity): void
    {
        if (!($entity instanceof $this->_entityName)) {
            throw new \DomainException(self::class . ' works only with "' . $this->_entityName . '" objects!');
        }

        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * @param int|object $entity entity object or it's id
     *
     * @throws \DomainException in case of entity class was not match for declared or entity is not a scalar
     * @throws \Doctrine\ORM\ORMException in case of entity was not found
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove($entity): void
    {
        if (!(is_int($entity) || $entity instanceof $this->_entityName)) {
            throw new \DomainException(self::class . '::remove() works only with "' . $this->_entityName . '" objects and integer ID\'s!');
        }

        if (is_scalar($entity)) {
            $entity = $this->_em->getReference($this->_entityName, $entity);
        }

        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
