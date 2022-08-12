<?php

namespace Finconsult\Documentor\Shared\Contexts\Security\Application\Query\GetProfile;

use Finconsult\Documentor\Shared\Contexts\Security\Model\Security;
use Finconsult\Documentor\Shared\Layers\Application\Query\QueryHandlerInterface;

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
