<?php

namespace Finconsult\Documentor\Shared\Application\Query;

interface QueryBusInterface
{
    public function execute(QueryInterface $query): mixed;
}
