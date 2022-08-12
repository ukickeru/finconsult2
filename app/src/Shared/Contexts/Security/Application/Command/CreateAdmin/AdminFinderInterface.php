<?php

namespace Finconsult\Documentor\Shared\Contexts\Security\Application\Command\CreateAdmin;

use Finconsult\Documentor\Shared\Contexts\Security\Model\Entity\User;

interface AdminFinderInterface
{
    public function findAdminOrNullByEmail(string $email): ?User;
}
