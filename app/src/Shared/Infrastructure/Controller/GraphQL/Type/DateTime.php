<?php

namespace Finconsult\Documentor\Shared\Infrastructure\Controller\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Scalar]
class DateTime
{
    public static function serialize(\DateTimeInterface $value): string
    {
        return $value->format('Y-m-d H:i:s');
    }

    public static function parseValue($value): \DateTimeInterface
    {
        return new \DateTime($value);
    }

    public static function parseLiteral($valueNode): \DateTimeInterface
    {
        return new \DateTime($valueNode->value);
    }
}
