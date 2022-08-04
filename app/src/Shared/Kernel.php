<?php

namespace Finconsult\Documentor\Shared;

use Finconsult\Documentor\Shared\Infrastructure\Controller\GraphQL\DependencyInjection\HandlerCompilerPass;
use Finconsult\Documentor\Shared\Temporal\DependencyInjection\CompilerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait {
        configureContainer as defaultConfigureContainer;
        configureRoutes as defaultConfigureRoutes;
    }

    public function build(ContainerBuilder $container): void
    {
        $temporalInit = new CompilerPass();
        $temporalInit->register($container);
        $container->addCompilerPass($temporalInit);

        $gqlHandlerPass = new HandlerCompilerPass();
        $gqlHandlerPass->register($container);
        $container->addCompilerPass($gqlHandlerPass);
    }

    private function configureContainer(ContainerConfigurator $container, LoaderInterface $loader, ContainerBuilder $builder): void
    {
        $this->defaultConfigureContainer($container, $loader, $builder);
        $this->configureContainerForContexts($container, $loader, $builder);
    }

    /**
     * Импортирует конфигурацию из вложенных контекстов.
     */
    private function configureContainerForContexts(ContainerConfigurator $container, LoaderInterface $loader, ContainerBuilder $builder): void
    {
        $projectDir = $this->getProjectDir();

        $container->import($projectDir . '/src/**/config/{packages}/*.yaml');
        $container->import($projectDir . '/src/**/config/{packages}/' . $this->environment . '/*.yaml');
        $container->import($projectDir . '/src/**/config/{services}.yaml');
        $container->import($projectDir . '/src/**/config/{services}_' . $this->environment . '.yaml');
    }

    private function configureRoutes(RoutingConfigurator $routes): void
    {
        $this->defaultConfigureRoutes($routes);
        $this->configureRoutesForContexts($routes);
    }

    /**
     * Импортирует маршруты из вложенных контекстов.
     */
    private function configureRoutesForContexts(RoutingConfigurator $routes): void
    {
        $projectDir = $this->getProjectDir();

        $routes->import($projectDir . '/src/**/config/{routes}/' . $this->environment . '/*.yaml');
        $routes->import($projectDir . '/src/**/config/{routes}/*.yaml');
        $routes->import($projectDir . '/src/**/config/{routes}.yaml');
    }
}
