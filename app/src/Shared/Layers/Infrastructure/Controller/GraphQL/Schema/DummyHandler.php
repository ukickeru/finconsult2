<?php

namespace Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\Schema;

use Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\HandlerInterface;
use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Provider(
    targetQueryTypes: ['PublicQuery', 'RootQuery'],
    targetMutationTypes: ['PublicMutation', 'RootMutation']
)]
// @todo: remove after schemas filling
class DummyHandler implements HandlerInterface
{
    #[GQL\Query(name: 'dummy_query', type: 'Boolean!')]
    public function query(): bool
    {
        return true;
    }

    #[GQL\Mutation(name: 'dummy_mutation', type: 'Boolean!')]
    public function mutation(): bool
    {
        return true;
    }
}
