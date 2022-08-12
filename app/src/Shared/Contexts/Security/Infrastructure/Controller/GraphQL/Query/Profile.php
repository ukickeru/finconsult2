<?php

namespace Finconsult\Documentor\Shared\Contexts\Security\Infrastructure\Controller\GraphQL\Query;

use Finconsult\Documentor\Shared\Contexts\Security\Application\Query\GetProfile\Handler;
use Finconsult\Documentor\Shared\Contexts\Security\Application\Query\GetProfile\ProfileDTO;
use Finconsult\Documentor\Shared\Contexts\Security\Application\Query\GetProfile\Query;
use Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\HandlerInterface;
use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Provider(targetQueryTypes: 'RootQuery')]
class Profile implements HandlerInterface
{
    public function __construct(private Handler $handler)
    {
    }

    #[GQL\Query(name: 'security_profile')]
    public function handle(): ProfileDTO
    {
        return $this->handler->handle(new Query());
    }
}
