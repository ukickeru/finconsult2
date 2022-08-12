<?php

namespace Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\Exception;

use Overblog\GraphQLBundle\Error\UserError as GraphQLError;

class UserError extends GraphQLError
{
    public function getCategory(): string
    {
        return 'CustomError';
    }
}
