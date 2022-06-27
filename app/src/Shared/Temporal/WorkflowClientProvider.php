<?php

namespace Finconsult\Documentor\Shared\Temporal;

use Finconsult\Documentor\Shared\Temporal\Initialization\Environment;
use Temporal\Client\ClientOptions;
use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;

class WorkflowClientProvider
{
    private static ?WorkflowClient $workflowClient = null;

    public static function instance(?string $address = null, ?string $namespace = null): WorkflowClient
    {
        if (!self::$workflowClient) {
            $env = Environment::fromGlobals();
            self::$workflowClient = WorkflowClient::create(
                ServiceClient::create($address ?? $env->getTemporalAddress()),
                (new ClientOptions())->withNamespace($namespace ?? $env->getTemporalNamespace())
            );
        }

        return self::$workflowClient;
    }
}
