<?php

use Finconsult\Documentor\Shared\Kernel;
use Finconsult\Documentor\Shared\Temporal\Initialization\Environment;
use Finconsult\Documentor\Shared\Temporal\Initialization\TemporalContainer;
use Temporal\WorkerFactory;

require_once 'vendor/autoload.php';

// Создаёт Worker'ы Workflow и Activity для для определённой очереди задач
$factory = WorkerFactory::create();

// Worker, который слушает указанную очередь задачи и содержит реализации Workflow и Activity
$worker = $factory->newWorker(getenv('TEMPORAL_QUEUE_NAME') ?: 'default');

// Единожды запускаем Kernel для получения DIC
$env = Environment::fromGlobals();
$kernel = new Kernel($env->getEnv(), $env->getDebug());
$kernel->boot();
$container = $kernel->getContainer();

// Получаем объект с зарегистрированными Workflows и Activities
$temporalContainer = $container->get(TemporalContainer::class);

// Регистрируем ТИПЫ Workflows
foreach ($temporalContainer->getWorkflowTypes() as $workflow) {
    $worker->registerWorkflowTypes($workflow);
}

// Регистрируем РЕАЛИЗАЦИЮ Activities
foreach ($temporalContainer->getActivityImplementations() as $activity) {
    $worker->registerActivity($activity::class, fn(ReflectionClass $class) => $activity);
}

$factory->run();
