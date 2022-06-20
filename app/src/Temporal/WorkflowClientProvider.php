<?php

namespace App\Temporal;

use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;

class WorkflowClientProvider
{
    public static function create(string $address = 'localhost:7233'): WorkflowClient
    {
        return WorkflowClient::create(
            ServiceClient::create($address)
        );
    }
}
