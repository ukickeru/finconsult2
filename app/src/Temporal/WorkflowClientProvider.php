<?php

namespace App\Temporal;

use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;

class WorkflowClientProvider
{
    private static ?WorkflowClient $workflowClient = null;

    public static function instance(string $address = 'localhost:7233'): WorkflowClient
    {
        if (!self::$workflowClient) {
            self::$workflowClient = WorkflowClient::create(
                ServiceClient::create($address)
            );
        }

        return self::$workflowClient;
    }
}
