<?php

namespace Finconsult\Documentor\Shared\Security\Infrastructure\Controller\GraphQL\Mutation;

use Finconsult\Documentor\Shared\Infrastructure\Controller\GraphQL\HandlerInterface;
use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Provider(targetMutationTypes: 'RootMutation')]
class CreateUser implements HandlerInterface
{
    #[GQL\Mutation(name: 'security_createUser', type: 'Boolean')]
    public function handle(): void
    {
    }
}
