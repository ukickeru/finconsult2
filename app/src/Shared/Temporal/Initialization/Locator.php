<?php

namespace Finconsult\Documentor\Shared\Temporal\Initialization;

use Finconsult\Documentor\Shared\Temporal\ActivityInterface;
use Finconsult\Documentor\Shared\Temporal\WorkflowInterface;
use Spiral\Tokenizer\ClassesInterface;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Finder\Finder;

class Locator
{
    private ClassesInterface $classLocator;

    public function __construct(private ContainerBuilder $container, string $dir)
    {
        $this->classLocator = new ClassLocator(
            Finder::create()->files()->in($dir)
        );
    }

    public function getWorkflowTypes(): array
    {
        $workflows = [];

        foreach ($this->getAvailableDeclarations() as $class) {
            if ($class->implementsInterface(WorkflowInterface::class)
                && $this->container->has($class->getName())
            ) {
                $workflows[] = $class->getName();
            }
        }

        return $workflows;
    }

    public function getActivityImplementations(): array
    {
        $activities = [];

        foreach ($this->getAvailableDeclarations() as $class) {
            if ($class->implementsInterface(ActivityInterface::class)
                && $this->container->has($class->getName())
            ) {
                $activities[] = new Reference($class->getName());
            }
        }

        return $activities;
    }

    private function getAvailableDeclarations(): \Generator
    {
        foreach ($this->classLocator->getClasses() as $class) {
            if ($class->isAbstract() || $class->isInterface()) {
                continue;
            }

            yield $class;
        }
    }
}
