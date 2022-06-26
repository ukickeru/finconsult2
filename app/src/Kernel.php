<?php

namespace App;

use App\Temporal\Initialization\CompilerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function build(ContainerBuilder $container): void
    {
        $temporalInit = new CompilerPass();
        $temporalInit->register($container);
        $container->addCompilerPass($temporalInit);
    }
}
