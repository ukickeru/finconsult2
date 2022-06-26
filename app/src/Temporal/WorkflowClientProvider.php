<?php

namespace App\Temporal;

use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;

class WorkflowClientProvider
{
    public const TEMPORAL_ADDRESS = 'temporal:7233';

    private static ?WorkflowClient $workflowClient = null;

    public static function instance(string $address = self::TEMPORAL_ADDRESS): WorkflowClient
    {
        if (!self::$workflowClient) {
            self::$workflowClient = WorkflowClient::create(
                ServiceClient::create($address)
            );
        }

        return self::$workflowClient;
    }
}
