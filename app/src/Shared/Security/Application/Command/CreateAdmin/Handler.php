<?php

namespace Finconsult\Documentor\Shared\Security\Application\Command\CreateAdmin;

use Finconsult\Documentor\Shared\Application\Command\CommandHandlerInterface;
use Finconsult\Documentor\Shared\Security\Infrastructure\Repository\UserRepository;
use Finconsult\Documentor\Shared\Security\Model\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Handler implements CommandHandlerInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $repository
    ) {
    }

    public function handle(Command $command): void
    {
        $user = $this->repository->findAdminOrNullByEmail($command->email);

        if ($user instanceof User) {
            $command->updateUser($user, $this->passwordHasher);
        } else {
            $user = $command->createUser($this->passwordHasher);
        }

        $this->repository->save($user);
    }
}
