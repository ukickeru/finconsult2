<?php

namespace Finconsult\Documentor\Shared\Layers\Application\Query;

interface QueryBusInterface
{
    public function execute(QueryInterface $query): mixed;
}
