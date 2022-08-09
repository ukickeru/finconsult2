<?php

namespace Finconsult\Documentor\Shared\Security\Application\Query\GetProfile;

use Finconsult\Documentor\Shared\Security\Model\Entity\User;
use Overblog\GraphQLBundle\Annotation as GQL;

#[GQL\Type]
class ProfileDTO
{
    public function __construct(
        #[GQL\Field]
        public string $email,
        #[GQL\Field]
        public string $name,
        #[GQL\Field]
        public string $role
    ) {
    }

    public static function fromDomainUser(User $user): self
    {
        return new self($user->getEmail(), $user->getName(), $user->getRole());
    }
}
