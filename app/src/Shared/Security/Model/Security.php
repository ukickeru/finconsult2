<?php

namespace Finconsult\Documentor\Shared\Security\Model;

use Finconsult\Documentor\Shared\Security\Model\Entity\User;
use Symfony\Component\Security\Core\Security as SymfonySecurity;

/**
 * @phpstan-ignore-next-line
 */
class Security extends SymfonySecurity
{
    public function getUser(): User
    {
        /* @phpstan-ignore-next-line */
        return parent::getUser();
    }
}
