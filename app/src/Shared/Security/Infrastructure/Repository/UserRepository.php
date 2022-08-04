<?php

namespace Finconsult\Documentor\Shared\Security\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Finconsult\Documentor\Shared\Infrastructure\Persistence\Doctrine\RepositoryTrait;
use Finconsult\Documentor\Shared\Security\Application\Command\CreateAdmin\AdminFinderInterface;
use Finconsult\Documentor\Shared\Security\Model\Entity\User;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[] findAll()
 * @method User[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements AdminFinderInterface
{
    use RepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findAdminOrNullByEmail(string $email): ?User
    {
        return $this->findOneBy([
            'email' => $email,
            'role' => User::ROLE_ADMIN,
        ]);
    }
}
