<?php

namespace App\App\Hello;

use Temporal\Activity\ActivityInterface;

#[ActivityInterface(prefix: 'demo_activity.')]
interface DemoActivityInterface
{
    public function hello(string $name): string;

    public function slow(string $name): string;
}
