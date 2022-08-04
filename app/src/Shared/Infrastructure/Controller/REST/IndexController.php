<?php

namespace Finconsult\Documentor\Shared\Infrastructure\Controller\REST;

use Carbon\CarbonInterval;
use Finconsult\Documentor\Sample\Hello\DemoWorkflowInterface;
use Finconsult\Documentor\Shared\Temporal\WorkflowClientProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Temporal\Client\WorkflowOptions;
use Temporal\Common\RetryOptions;

class IndexController extends AbstractController
{
    #[Route(path: '/hello', name: 'hello')]
    public function index(): Response
    {
        $workflowClient = WorkflowClientProvider::instance();

        $demo = $workflowClient->newWorkflowStub(
            DemoWorkflowInterface::class,
            WorkflowOptions::new()
                ->withWorkflowExecutionTimeout(CarbonInterval::seconds(5))
                ->withRetryOptions(
                    (new RetryOptions())->withMaximumAttempts(1)
                )
        );

        $result = $demo->run('Pavel', 1);

        return new Response(
            serialize($result),
            200
        );
    }
}
