<?php

use Finconsult\Documentor\Shared\Kernel;
use Finconsult\Documentor\Shared\Temporal\Initialization\Environment;
use Finconsult\Documentor\Shared\Temporal\Initialization\TemporalContainer;
use Temporal\WorkerFactory;

require_once 'vendor/autoload.php';

// Провайдер переменных окружения
$env = Environment::fromGlobals();

// Создаёт Workflow и Activity Workers для определённой очереди задач
$factory = WorkerFactory::create();

// Worker, который слушает указанную очередь задачи и содержит реализации Workflow и Activity
$worker = $factory->newWorker($env->getTemporalNamespace());

// Единожды запускаем Kernel для получения DIC
$kernel = new Kernel($env->getEnv(), $env->isDebugEnabled());
$kernel->boot();
$container = $kernel->getContainer();

// Получаем объект с зарегистрированными Workflows и Activities
$temporalContainer = $container->get(TemporalContainer::class);

// Регистрируем Workflows
foreach ($temporalContainer->getWorkflowTypes() as $workflow) {
    $worker->registerWorkflowTypes($workflow);
}

// Регистрируем Activities
foreach ($temporalContainer->getActivityImplementations() as $activity) {
    $worker->registerActivity($activity::class, fn(ReflectionClass $class) => $activity);
}

$factory->run();
