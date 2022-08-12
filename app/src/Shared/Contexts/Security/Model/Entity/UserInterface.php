<?php

namespace Finconsult\Documentor\Shared\Contexts\Security\Model\Entity;

interface UserInterface
{
    public function getEmail(): string;

    public function isEnabled(): bool;

    public function disable(): void;

    public function enable(): void;
}
