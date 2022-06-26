<?php

namespace Finconsult\Documentor\App\Hello;

use Finconsult\Documentor\Temporal\WorkflowInterface as DomainWorkflowInterface;
use Temporal\Workflow\WorkflowInterface;
use Temporal\Workflow\WorkflowMethod;

#[WorkflowInterface]
interface DemoWorkflowInterface extends DomainWorkflowInterface
{
    #[WorkflowMethod(name: 'demo_workflow')]
    public function run(
        string $name,
        int $count
    );
}
