<?php

namespace Finconsult\Documentor\Shared\Layers\Model;

interface IdentityGeneratorInterface
{
    public function generateId(): int|string;
}
