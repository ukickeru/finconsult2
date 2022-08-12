<?php

namespace Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\Exception;

use Overblog\GraphQLBundle\Error\UserError as GraphQLError;

class SystemError extends GraphQLError
{
    public function getCategory(): string
    {
        return 'SystemError';
    }
}
