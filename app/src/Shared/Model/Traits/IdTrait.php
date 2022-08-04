<?php

namespace Finconsult\Documentor\Shared\Model\Traits;

use Doctrine\ORM\Mapping as ORM;
use Overblog\GraphQLBundle\Annotation as GQL;

trait IdTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[GQL\Field(type: 'ID!')]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
