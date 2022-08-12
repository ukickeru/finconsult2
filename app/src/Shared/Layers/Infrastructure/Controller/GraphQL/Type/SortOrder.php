<?php

namespace Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\Type;

use Overblog\GraphQLBundle\Annotation as GQL;
use Symfony\Component\Validator\Constraints as Assert;

#[GQL\Input]
#[GQL\Description('Тип, предназначенный для описания сортировки коллекции')]
class SortOrder
{
    #[GQL\Field(type: 'String!')]
    #[GQL\Description('Строка, совпадающая с наименованием одного из полей объекта, по которому будет произведена сортировка')]
    public string $fieldName;

    #[Assert\Regex(pattern: '/^(ASC|DESC)?$/', message: "Строка должна быть в формате 'ASC' или 'DESC'!")]
    #[GQL\Field(type: 'String!')]
    #[GQL\Description("Строка в формате 'ASC' или 'DESC', определяющая порядок сортировки по указанному полю")]
    public string $sortOrder;
}
