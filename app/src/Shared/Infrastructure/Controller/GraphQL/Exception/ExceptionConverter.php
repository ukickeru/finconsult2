<?php

namespace Finconsult\Documentor\Shared\Infrastructure\Controller\GraphQL\Exception;

use Finconsult\Documentor\Shared\Infrastructure\Controller\HttpExceptionNormalizerTrait;
use GraphQL\Error\Error;
use Overblog\GraphQLBundle\Error\ExceptionConverterInterface;

class ExceptionConverter implements ExceptionConverterInterface
{
    use HttpExceptionNormalizerTrait;

    public function convertException(\Throwable $exception): \Throwable
    {
        if ($exception instanceof Error) {
            return $exception;
        }

        if ($exception instanceof \LogicException) {
            return new UserError($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }

        return new SystemError($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
    }
}
