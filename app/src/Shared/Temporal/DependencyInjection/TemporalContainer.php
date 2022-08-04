<?php

namespace Finconsult\Documentor\Shared\Temporal\DependencyInjection;

use Temporal\Worker\WorkerFactoryInterface;
use Temporal\WorkerFactory;

class TemporalContainer
{
    private Environment $environment;

    public function __construct(
        private array $workflowTypes,
        private array $activityImplementations
    ) {
        $this->environment = Environment::fromGlobals();
    }

    public function getConfiguredFactory(): WorkerFactoryInterface
    {
        $factory = WorkerFactory::create();
        $worker = $factory->newWorker($this->environment->getTemporalNamespace());

        foreach ($this->workflowTypes as $workflow) {
            $worker->registerWorkflowTypes($workflow);
        }

        foreach ($this->activityImplementations as $activity) {
            $worker->registerActivity($activity::class, fn (\ReflectionClass $class) => $activity);
        }

        return $factory;
    }
}
