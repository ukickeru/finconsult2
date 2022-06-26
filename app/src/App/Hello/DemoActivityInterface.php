<?php

namespace Finconsult\Documentor\App\Hello;

use Finconsult\Documentor\Shared\Temporal\ActivityInterface as DomainActivityInterface;
use Temporal\Activity\ActivityInterface;

#[ActivityInterface(prefix: 'demo_activity.')]
interface DemoActivityInterface extends DomainActivityInterface
{
    public function hello(string $name): string;

    public function slow(string $name): string;
}
