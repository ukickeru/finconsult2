<?php

namespace Finconsult\Documentor\Shared\Layers\Model;

interface IdentityInterface
{
    public function getId(): string;

    public function isSame(self $identity): bool;
}
