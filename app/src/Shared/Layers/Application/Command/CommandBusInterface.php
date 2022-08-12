<?php

namespace Finconsult\Documentor\Shared\Layers\Application\Command;

interface CommandBusInterface
{
    public function execute(CommandInterface $command): mixed;
}
