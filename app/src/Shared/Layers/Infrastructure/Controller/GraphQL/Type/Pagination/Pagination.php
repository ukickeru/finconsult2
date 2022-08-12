<?php

namespace Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\Type\Pagination;

use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Input]
#[GQL\Description('Тип входных данных, предназначенный для постарничного вывода коллекций в стиле Relay (https://relay.dev/)')]
class Pagination
{
    public const DEFAULT_LIMIT = 10;

    #[GQL\Field(type: 'Int')]
    #[GQL\Description('Количество первых запрошенных элементов коллекции, следующих после указателя after, или перед указателем before')]
    public $first = self::DEFAULT_LIMIT;

    #[GQL\Field(type: 'Int')]
    #[GQL\Description('Количество последних запрошенных элементов коллекции, следующих после указателя after, или перед указателем before. Имеет приоритет перед first')]
    public $last = null;

    #[GQL\Field(type: 'String')]
    #[GQL\Description('Указатель на элемент коллекции, после которого будут выведены запрошенные элементы')]
    public $after = null;

    #[GQL\Field(type: 'String')]
    #[GQL\Description('Указатель на элемент коллекции, перед которым будут выведены запрошенные элементы. Имеет приоритет перед after')]
    public $before = null;

    public function toArray(): array
    {
        $paginationType = [];

        if (null !== $this->first) {
            $paginationType['first'] = $this->first;
        }

        if (null !== $this->last) {
            $paginationType['last'] = $this->last;
        }

        if (null !== $this->after) {
            $paginationType['after'] = $this->after;
        }

        if (null !== $this->before) {
            $paginationType['before'] = $this->before;
        }

        return $paginationType;
    }
}
