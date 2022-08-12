<?php

namespace Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\DependencyInjection;

use Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\HandlerInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HandlerCompilerPass implements CompilerPassInterface
{
    private const SERVICE_ID = HandlerInterface::class;
    private const SERVICE_TAG = 'app.gql.handler';

    public function register(ContainerBuilder $container): self
    {
        $container->registerForAutoconfiguration(self::SERVICE_ID)
            ->addTag(self::SERVICE_TAG);

        return $this;
    }

    public function process(ContainerBuilder $container): void
    {
        $taggedServiceIds = $container->findTaggedServiceIds(self::SERVICE_TAG);

        foreach (array_keys($taggedServiceIds) as $serviceId) {
            if (self::SERVICE_ID !== $serviceId) {
                $container->findDefinition($serviceId)
                    ->setPublic(true);
            }
        }
    }
}
