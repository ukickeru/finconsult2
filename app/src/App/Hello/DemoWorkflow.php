<?php

namespace Finconsult\Documentor\App\Hello;

use Temporal\Activity\ActivityOptions;
use Temporal\Promise;
use Temporal\Workflow;

class DemoWorkflow implements DemoWorkflowInterface
{
    public function run(string $name, int $count): \Generator
    {
        $activity = Workflow::newActivityStub(
            DemoActivityInterface::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(5)
        );

        $promise = [];
        for ($i = 0; $i < $count; ++$i) {
            $promise[] = $activity->slow($name);
        }

        return yield Promise::all($promise);
    }
}
