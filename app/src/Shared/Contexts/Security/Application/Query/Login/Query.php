<?php

namespace Finconsult\Documentor\Shared\Contexts\Security\Application\Query\Login;

use Finconsult\Documentor\Shared\Layers\Application\Query\QueryInterface;

class Query implements QueryInterface
{
    public function __construct(public string $email, public string $password)
    {
    }
}
