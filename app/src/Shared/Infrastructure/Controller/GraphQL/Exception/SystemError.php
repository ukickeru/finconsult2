<?php

namespace Finconsult\Documentor\Shared\Infrastructure\Controller\GraphQL\Exception;

use Overblog\GraphQLBundle\Error\UserError as GraphQLError;

class SystemError extends GraphQLError
{
    public function getCategory(): string
    {
        return 'SystemError';
    }
}
