<?php

namespace Finconsult\Documentor\Shared\Security\Application\Query\Login;

use Finconsult\Documentor\Shared\Application\Query\QueryHandlerInterface;
use Finconsult\Documentor\Shared\Security\Infrastructure\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Handler implements QueryHandlerInterface
{
    public function __construct(
        private JWTTokenManagerInterface $tokenManager,
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $userRepository
    ) {
    }

    public function handle(Query $query): string
    {
        $user = $this->userRepository->findOneBy(['email' => $query->email]);

        if (null === $user) {
            throw new \LogicException('Пользователь с email "' . $query->email . '" не найден!');
        }

        if (!$this->passwordHasher->isPasswordValid($user, $query->password)) {
            throw new \LogicException('Неверный пароль!');
        }

        return $this->tokenManager->create($user);
    }
}