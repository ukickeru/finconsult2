<?php

namespace Finconsult\Documentor\Shared\Security\Application\Query\Login;

use Finconsult\Documentor\Shared\Application\Query\QueryInterface;

class Query implements QueryInterface
{
    public function __construct(public string $email, public string $password)
    {
    }
}
