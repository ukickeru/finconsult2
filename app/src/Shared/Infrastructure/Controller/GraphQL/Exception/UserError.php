<?php

namespace Finconsult\Documentor\Shared\Infrastructure\Controller\GraphQL\Exception;

use Overblog\GraphQLBundle\Error\UserError as GraphQLError;

class UserError extends GraphQLError
{
    public function getCategory(): string
    {
        return 'CustomError';
    }
}
