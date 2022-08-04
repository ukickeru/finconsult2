<?php

namespace Finconsult\Documentor\Shared\Security\Application\Command\CreateAdmin;

use Finconsult\Documentor\Shared\Security\Model\Entity\User;

interface AdminFinderInterface
{
    public function findAdminOrNullByEmail(string $email): ?User;
}
