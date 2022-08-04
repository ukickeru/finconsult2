<?php

namespace Finconsult\Documentor\Shared\Temporal\DependencyInjection;

use Finconsult\Documentor\Shared\Temporal\ActivityInterface;
use Finconsult\Documentor\Shared\Temporal\WorkflowInterface;
use Spiral\RoadRunner\Environment as RREnv;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CompilerPass implements CompilerPassInterface
{
    private const WORKFLOW_SERVICE_TAG = 'app.temporal.workflow';
    private const ACTIVITY_SERVICE_TAG = 'app.temporal.activity';

    private RREnv $environment;

    public function __construct()
    {
        $this->environment = RREnv::fromGlobals();
    }

    public function register(ContainerBuilder $container): void
    {
        if (!$this->isTemporalMode()) {
            return;
        }

        $container
            ->register(WorkflowInterface::class)
            ->addTag(self::WORKFLOW_SERVICE_TAG);

        $container
            ->register(ActivityInterface::class)
            ->addTag(self::ACTIVITY_SERVICE_TAG);
    }

    public function process(ContainerBuilder $container): void
    {
        if (
            !$this->isTemporalMode()
            || !$container->has(WorkflowInterface::class)
            || !$container->has(ActivityInterface::class)
        ) {
            return;
        }

        $locator = new Locator($container, $container->getParameter('kernel.project_dir') . '/src');

        $container
            ->register(TemporalContainer::class, TemporalContainer::class)
            ->setArguments([
                '$workflowTypes' => $locator->getWorkflowTypes(),
                '$activityImplementations' => $locator->getActivityImplementations(),
            ])
            ->setPublic(true);
    }

    private function isTemporalMode(): bool
    {
        return true;

        return RREnv\Mode::MODE_TEMPORAL === $this->environment->getMode();
    }
}
