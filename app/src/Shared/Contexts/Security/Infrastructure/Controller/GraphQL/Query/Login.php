<?php

namespace Finconsult\Documentor\Shared\Contexts\Security\Infrastructure\Controller\GraphQL\Query;

use Finconsult\Documentor\Shared\Contexts\Security\Application\Query\Login\Handler;
use Finconsult\Documentor\Shared\Contexts\Security\Application\Query\Login\Query;
use Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\HandlerInterface;
use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Provider(targetQueryTypes: 'PublicQuery')]
class Login implements HandlerInterface
{
    public function __construct(private Handler $handler)
    {
    }

    #[GQL\Query(name: 'security_login', type: 'String!')]
    #[GQL\Arg(name: 'email', type: 'String!', description: 'Email')]
    #[GQL\Arg(name: 'password', type: 'String!', description: 'Пароль')]
    public function handle(string $email, string $password): string
    {
        return $this->handler->handle(new Query($email, $password));
    }
}
