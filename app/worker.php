<?php

declare(strict_types=1);

use App\Kernel;
use App\Temporal\Locator;
use Spiral\RoadRunner\Environment;
use Spiral\RoadRunner\Environment\Mode;
use Temporal\WorkerFactory;

ini_set('display_errors', 'stderr');

/* @todo: инкапсулировать */
if ($_ENV['RR_MODE'] === 'http') {
    $_SERVER['SCRIPT_FILENAME'] = dirname(__FILE__) . '/public/index.php';
    require_once dirname(__FILE__) . '/public/index.php';
}

require_once 'vendor/autoload.php';

$env = Environment::fromGlobals();

if ($env->getMode() === Mode::MODE_TEMPORAL) {

    // Finds all workflows and activities in a given directory
    $locator = Locator::create(__DIR__ . '/src/');

    // Initiates and runs task queue specific activity and workflow workers
    $factory = WorkerFactory::create();

    // Worker that listens on a task queue and hosts both workflow and activity implementations.
    /* @todo: забиндить ID очереди как переменную окружения */
    $worker = $factory->newWorker();

    // Boot Kernel to provide DIC
    $environment = App\Temporal\Environment::fromGlobals();
    $symfonyKernel = new Kernel(
        $environment->get('APP_ENV','prod'),
        (bool) $environment->get('APP_DEBUG',false)
    );
    $symfonyKernel->boot();
    $container = $symfonyKernel->getContainer();

    // Register workflow types
    foreach ($locator->getWorkflowTypes() as $workflowType) {
        $worker->registerWorkflowTypes($workflowType);
    }

    // Register activities instances
    foreach ($locator->getActivityTypes() as $activityType) {
        $activityStub = $container->get($activityType);
        $worker->registerActivity($activityType, fn(ReflectionClass $class) => $container->get($class->getName()));
    }

    $factory->run();
}
