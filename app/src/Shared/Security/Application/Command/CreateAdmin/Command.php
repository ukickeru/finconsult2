<?php

namespace Finconsult\Documentor\Shared\Security\Application\Command\CreateAdmin;

use Finconsult\Documentor\Shared\Application\Command\CommandInterface;
use Finconsult\Documentor\Shared\Security\Model\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Command implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $name,
        public string $password
    ) {
    }

    public function createUser(UserPasswordHasherInterface $passwordHasher): User
    {
        return new User(
            $this->email,
            $this->name,
            $this->password,
            $passwordHasher,
            User::ROLE_ADMIN
        );
    }

    public function updateUser(User $user, UserPasswordHasherInterface $passwordHasher): User
    {
        if (!$user->isAdmin()) {
            throw new \DomainException('Указанный пользователь не является администратором!');
        }

        return $user->setEmail($this->email)
            ->setName($this->name)
            ->setPassword($this->password, $passwordHasher);
    }
}
