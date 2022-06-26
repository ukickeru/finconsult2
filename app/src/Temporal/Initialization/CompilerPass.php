<?php

namespace App\Temporal\Initialization;

use App\Temporal\ActivityInterface;
use App\Temporal\WorkflowInterface;
use Spiral\RoadRunner\Environment as RREnv;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

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
            ->registerForAutoconfiguration(WorkflowInterface::class)
            ->addTag(self::WORKFLOW_SERVICE_TAG);

        $container
            ->registerForAutoconfiguration(ActivityInterface::class)
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

        $temporalContainer = $container->findDefinition(TemporalContainer::class);

        $this->addTagToContainer(self::WORKFLOW_SERVICE_TAG, $temporalContainer, $container);
        $this->addTagToContainer(self::ACTIVITY_SERVICE_TAG, $temporalContainer, $container);
    }

    private function addTagToContainer(string $tag, Definition $temporalContainer, ContainerBuilder $container): void
    {
        $taggedServices = $container->findTaggedServiceIds($tag);

        if (empty($taggedServices)) {
            return;
        }

        switch ($tag) {
            case self::WORKFLOW_SERVICE_TAG:
                $this->registerWorkflowTypes($temporalContainer, $taggedServices);
                break;
            case self::ACTIVITY_SERVICE_TAG:
                $this->registerActivityImplementations($temporalContainer, $taggedServices);
                break;
        }
    }

    private function registerWorkflowTypes(Definition $definition, array $taggedServices): void
    {
        foreach (array_keys($taggedServices) as $serviceId) {
            if (WorkflowInterface::class === $serviceId) {
                continue;
            }

            $definition->addMethodCall('addWorkflowType', [
                $serviceId,
            ]);
        }
    }

    private function registerActivityImplementations(Definition $definition, array $taggedServices): void
    {
        foreach (array_keys($taggedServices) as $serviceId) {
            if (ActivityInterface::class == $serviceId) {
                continue;
            }

            $definition->addMethodCall('addActivityImplementation', [
                new Reference($serviceId),
            ]);
        }
    }

    private function isTemporalMode(): bool
    {
        return RREnv\Mode::MODE_TEMPORAL === $this->environment->getMode();
    }
}
