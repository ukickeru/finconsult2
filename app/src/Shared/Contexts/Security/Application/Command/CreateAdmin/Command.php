<?php

namespace Finconsult\Documentor\Shared\Contexts\Security\Application\Command\CreateAdmin;

use Finconsult\Documentor\Shared\Contexts\Security\Model\Entity\User;
use Finconsult\Documentor\Shared\Contexts\Security\Model\UserFactory;
use Finconsult\Documentor\Shared\Layers\Application\Command\CommandInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Command implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $name,
        public string $password
    ) {
    }

    public function createAdmin(UserFactory $userFactory): User
    {
        return $userFactory->create(
            $this->email,
            $this->name,
            $this->password,
            User::ROLE_ADMIN
        );
    }

    public function updateAdmin(User $user, UserPasswordHasherInterface $passwordHasher): User
    {
        if (!$user->isAdmin()) {
            throw new \DomainException('Указанный пользователь не является администратором!');
        }

        return $user->setEmail($this->email)
            ->setName($this->name)
            ->setPassword($this->password, $passwordHasher);
    }
}
