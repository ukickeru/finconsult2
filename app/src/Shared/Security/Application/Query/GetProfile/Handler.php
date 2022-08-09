<?php

namespace Finconsult\Documentor\Shared\Security\Application\Query\GetProfile;

use Finconsult\Documentor\Shared\Application\Query\QueryHandlerInterface;
use Finconsult\Documentor\Shared\Security\Model\Security;

class Handler implements QueryHandlerInterface
{
    public function __construct(private Security $security)
    {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function handle(Query $query): ProfileDTO
    {
        return ProfileDTO::fromDomainUser($this->security->getUser());
    }
}
