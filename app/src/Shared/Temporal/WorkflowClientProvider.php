<?php

namespace Finconsult\Documentor\Shared\Temporal;

use Finconsult\Documentor\Shared\Temporal\DependencyInjection\Environment;
use Temporal\Client\ClientOptions;
use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;

// @todo: refactor this
class WorkflowClientProvider
{
    /**
     * @var WorkflowClient[]
     */
    private static array $clients = [];

    private static ?Environment $environment = null;

    public static function instance(?string $address = null, ?string $namespace = null): WorkflowClient
    {
        $address = strtolower($address ?: self::getEnvironment()->getTemporalAddress());
        $namespace = strtolower($namespace ?: self::getEnvironment()->getTemporalNamespace());

        if (!isset(self::$clients[$address . '-' . $namespace])) {
            self::$clients[$address . '-' . $namespace] = WorkflowClient::create(
                ServiceClient::create($address),
                (new ClientOptions())->withNamespace($namespace)
            );
        }

        return self::$clients[$address . '-' . $namespace];
    }

    private static function getEnvironment(): Environment
    {
        if (null === self::$environment) {
            self::$environment = Environment::fromGlobals();
        }

        return self::$environment;
    }
}
