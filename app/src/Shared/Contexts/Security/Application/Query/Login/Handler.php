<?php

namespace Finconsult\Documentor\Shared\Contexts\Security\Application\Query\Login;

use Finconsult\Documentor\Shared\Contexts\Security\Infrastructure\Repository\UserRepository;
use Finconsult\Documentor\Shared\Layers\Application\Query\QueryHandlerInterface;
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

        if (!$user->isEnabled()) {
            throw new \DomainException('Ваш аккаунт заблокирован! Пожалуйста, обратитесь к Администратору для разблокировки!');
        }

        try {
            return $this->tokenManager->create($user);
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Во время создания токена возникла ошибка: ' . $exception->getMessage());
        }
    }
}
