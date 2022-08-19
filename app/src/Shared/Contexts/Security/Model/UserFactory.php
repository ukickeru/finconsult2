<?php

namespace Finconsult\Documentor\Shared\Contexts\Security\Model;

use Finconsult\Documentor\Shared\Contexts\Security\Model\Entity\User;
use Finconsult\Documentor\Shared\Layers\Model\EntityFactoryInterface;
use Finconsult\Documentor\Shared\Layers\Model\IdentityGeneratorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory implements EntityFactoryInterface
{
    public function __construct(
        private IdentityGeneratorInterface $identityGenerator,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function create(
        string $email,
        string $name,
        string $password,
        string $role = User::ROLE_USER,
        bool $enabled = true
    ): User {
        return new User(
            $this->identityGenerator,
            $email,
            $name,
            $password,
            $this->passwordHasher,
            $role,
            $enabled
        );
    }
}
