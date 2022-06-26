<?php

declare(strict_types=1);

use App\Kernel;
use App\Temporal\Locator;
use Spiral\RoadRunner\Environment;
use Spiral\RoadRunner\Environment\Mode;
use Temporal\WorkerFactory;

// Логируем в RoadRunner
ini_set('display_errors', 'stderr');

// HTTP worker
if ($_ENV['RR_MODE'] === 'http') {
    // Устанавливаем SCRIPT_FILENAME для запуска успешного старта приложения из Symfony Runtime
    $_SERVER['SCRIPT_FILENAME'] = dirname(__FILE__) . '/public/index.php';
    require_once dirname(__FILE__) . '/public/index.php';
}

// Нельзя подключить раньше из-за Symfony Runtime
require_once 'vendor/autoload.php';

$env = Environment::fromGlobals();

// Temporal worker
if ($env->getMode() === Mode::MODE_TEMPORAL) {

    // Ищет все Workflow и Activities
    $locator = Locator::create(__DIR__ . '/src/');

    // Создаёт Worker'ы Workflow и Activity для для определённой очереди задач
    $factory = WorkerFactory::create();

    // Worker, который слушает указанную очередь задачи и содержит реализации Workflow и Activity
    /* @todo: забиндить ID очереди как переменную окружения */
    $worker = $factory->newWorker();

    // Единожды запускаем Kernel для получения DIC
    $environment = App\Temporal\Environment::fromGlobals();
    $symfonyKernel = new Kernel(
        $environment->get('APP_ENV','prod'),
        (bool) $environment->get('APP_DEBUG',false)
    );
    $symfonyKernel->boot();
    $container = $symfonyKernel->getContainer();

    // Регистрируем ТИПЫ Workflows
    foreach ($locator->getWorkflowTypes() as $workflowType) {
        $worker->registerWorkflowTypes($workflowType);
    }

    // Регистрируем РЕАЛИЗАЦИЮ Activities
    foreach ($locator->getActivityTypes() as $activityType) {
        $activityStub = $container->get($activityType);
        $worker->registerActivity($activityType, fn(ReflectionClass $class) => $container->get($class->getName()));
    }

    $factory->run();
}
