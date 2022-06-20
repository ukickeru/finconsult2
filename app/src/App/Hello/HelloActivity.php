<?php

namespace App\App\Hello;

class HelloActivity implements DemoActivityInterface
{
    public function hello(string $name): string
    {
        return sprintf('Hello, %s!', $name);
    }

    public function slow(string $name): string
    {
        sleep(1);

        return sprintf('Hello, %s!', $name);
    }
}
