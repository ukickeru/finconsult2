<?php

namespace Finconsult\Documentor\Shared\Temporal\DependencyInjection;

class Environment
{
    /**
     * @var array<string, string>
     */
    private array $env;

    public function __construct(array $env = [])
    {
        $this->env = $env;
    }

    public function get(string $name, mixed $default = ''): mixed
    {
        if (isset($this->env[$name]) || \array_key_exists($name, $this->env)) {
            return (string) $this->env[$name];
        }

        return $default;
    }

    public function getEnv(): string
    {
        return $this->get('APP_ENV', 'prod');
    }

    public function isDebugEnabled(): bool
    {
        return 'prod' !== $this->getEnv() && $this->get('APP_DEBUG', false);
    }

    public function getTemporalAddress(): string
    {
        return $this->get('TEMPORAL_CLI_ADDRESS', 'temporal:7233');
    }

    public function getTemporalNamespace(): string
    {
        return $this->get('TEMPORAL_NAMESPACE', 'default');
    }

    public static function fromGlobals(): self
    {
        return new self(\array_merge($_ENV, $_SERVER));
    }
}
