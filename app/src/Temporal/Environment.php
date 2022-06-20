<?php

namespace App\Temporal;

class Environment
{
    /**
     * @var array<string, string>
     */
    private array $env = [];

    public function __construct(array $env = [])
    {
        $this->env = $env;
    }

    public function get(string $name, mixed $default = ''): mixed
    {
        if (isset($this->env[$name]) || \array_key_exists($name, $this->env)) {
            /* @psalm-suppress RedundantCastGivenDocblockType */
            return (string) $this->env[$name];
        }

        return $default;
    }

    public static function fromGlobals(): self
    {
        $env = \array_merge($_ENV, $_SERVER);

        return new self($env);
    }
}