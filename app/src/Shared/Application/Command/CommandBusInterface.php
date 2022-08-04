<?php

namespace Finconsult\Documentor\Shared\Application\Command;

interface CommandBusInterface
{
    public function execute(CommandInterface $command): mixed;
}
