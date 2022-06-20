<?php

namespace App\App\Hello;

use Temporal\Workflow\WorkflowInterface;
use Temporal\Workflow\WorkflowMethod;

#[WorkflowInterface]
interface DemoWorkflowInterface
{
    #[WorkflowMethod(name: 'demo_workflow')]
    public function run(
        string $name,
        int $count
    );
}
