<?php

namespace Finconsult\Documentor\Shared\Layers\Model\Traits;

use Doctrine\ORM\Mapping as ORM;
use Finconsult\Documentor\Shared\Layers\Model\IdentityGeneratorInterface;
use Finconsult\Documentor\Shared\Layers\Model\IdentityInterface;
use Overblog\GraphQLBundle\Annotation as GQL;

trait IdentityTrait
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    #[GQL\Field(type: 'ID!')]
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function initId(IdentityGeneratorInterface $identityGenerator): void
    {
        $this->id = $identityGenerator->generateId();
    }

    public function isSame(IdentityInterface $identity): bool
    {
        return $this->id === $identity->getId();
    }
}
