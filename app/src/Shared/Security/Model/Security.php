<?php

namespace Finconsult\Documentor\Shared\Security\Model;

use Finconsult\Documentor\Shared\Security\Model\Entity\User;
use Symfony\Component\Security\Core\Security as SymfonySecurity;

class Security
{
    public function __construct(private SymfonySecurity $security)
    {
    }

    public function getUser(): User
    {
        /* @phpstan-ignore-next-line */
        return $this->security->getUser();
    }
}
