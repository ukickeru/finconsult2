<?php

use Finconsult\Documentor\Shared\Kernel;
use Finconsult\Documentor\Shared\Temporal\DependencyInjection\Environment;
use Finconsult\Documentor\Shared\Temporal\DependencyInjection\TemporalContainer;

require_once 'vendor/autoload.php';

// Провайдер переменных окружения
$env = Environment::fromGlobals();

// Единожды запускаем Kernel для получения DIC
$kernel = new Kernel($env->getEnv(), $env->isDebugEnabled());
$kernel->boot();
$container = $kernel->getContainer();

/** @var TemporalContainer $temporalContainer */
$temporalContainer = $container->get(TemporalContainer::class);

$factory = $temporalContainer->getConfiguredFactory();

$factory->run();
