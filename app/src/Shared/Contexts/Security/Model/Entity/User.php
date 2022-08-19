<?php

namespace Finconsult\Documentor\Shared\Contexts\Security\Model\Entity;

use Assert\Assert;
use Doctrine\ORM\Mapping as ORM;
use Finconsult\Documentor\Shared\Contexts\Security\Infrastructure\Repository\UserRepository;
use Finconsult\Documentor\Shared\Layers\Model\EntityInterface;
use Finconsult\Documentor\Shared\Layers\Model\IdentityGeneratorInterface;
use Finconsult\Documentor\Shared\Layers\Model\Traits\IdentityTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements EntityInterface, UserInterface, SymfonyUserInterface, PasswordAuthenticatedUserInterface
{
    use IdentityTrait;

    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_LAWYER = 'ROLE_LAWYER';
    public const ROLE_SENIOR_LAWYER = 'ROLE_SENIOR_LAWYER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_DEVELOPER = 'ROLE_DEVELOPER';
    public const AVAILABLE_ROLES = [
        self::ROLE_USER,
        self::ROLE_LAWYER,
        self::ROLE_SENIOR_LAWYER,
        self::ROLE_ADMIN,
        self::ROLE_DEVELOPER,
    ];

    #[ORM\Column(type: 'string', unique: true)]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $role = self::ROLE_USER;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'boolean')]
    private bool $enabled;

    public function __construct(
        IdentityGeneratorInterface $identityGenerator,
        string $email,
        string $name,
        string $password,
        UserPasswordHasherInterface $passwordHasher,
        string $role = self::ROLE_USER,
        bool $enabled = true
    ) {
        $this->initId($identityGenerator);
        $this->setEmail($email);
        $this->setName($name);
        $this->setRole($role);
        $this->setPassword($password, $passwordHasher);
        $this->enabled = $enabled;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        Assert::that($email)->email('Пожалуйста, введите валидный email!');

        $this->email = $email;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        Assert::lazy()
            ->tryAll()
            ->that($name, null, 'Имя должно быть представлено непустой строкой!')
            ->string()
            ->notEmpty()
            ->verifyNow();

        $this->name = $name;

        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function isUser(): bool
    {
        return self::ROLE_USER === $this->getRole();
    }

    public function isLawyer(): bool
    {
        return self::ROLE_LAWYER === $this->getRole();
    }

    public function isSeniorLawyer(): bool
    {
        return self::ROLE_SENIOR_LAWYER === $this->getRole();
    }

    public function isAdmin(): bool
    {
        return self::ROLE_ADMIN === $this->getRole();
    }

    public function isDeveloper(): bool
    {
        return self::ROLE_DEVELOPER === $this->getRole();
    }

    public function setRole(string $role): self
    {
        Assert::that($role)
            ->inArray(self::AVAILABLE_ROLES, 'Укажите допустимую роль пользователя!');

        $this->role = $role;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(
        string $password,
        UserPasswordHasherInterface $hasher
    ): self {
        Assert::lazy()
            ->tryAll()
            ->that($password, null, 'Пароль должен содержать как минимум 8 символов!')
            ->string()
            ->notEmpty()
            ->minLength(8)
            ->verifyNow();

        $this->password = $hasher->hashPassword($this, $password);

        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function disable(): void
    {
        $this->enabled = false;
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }
}
