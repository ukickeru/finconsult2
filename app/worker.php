<?php

declare(strict_types=1);

// Логируем в RoadRunner
ini_set('display_errors', 'stderr');

// Фрагмент ниже можно заменить следующей реализацией:
// Spiral\RoadRunner\Environment и Spiral\RoadRunner\Environment\Mode
// Сделано проще из-за проблем с Symfony/Runtime и vendor/autoload

// HTTP worker
if (getenv('RR_MODE') === 'http') {
    // Определяем скрипт для запуска приложения из Symfony/Runtime
    $_SERVER['SCRIPT_FILENAME'] = dirname(__FILE__) . '/public/index.php';
    require_once dirname(__FILE__) . '/public/index.php';
}

// Temporal worker
if (getenv('RR_MODE') === 'temporal') {
    require_once dirname(__FILE__) . '/temporal.php';
}
