<?php

namespace Finconsult\Documentor\Shared\Controller;

use Finconsult\Documentor\Sample\Hello\DemoWorkflowInterface;
use Finconsult\Documentor\Shared\Temporal\WorkflowClientProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Temporal\Client\WorkflowOptions;

class IndexController extends AbstractController
{
    #[Route(path: '/hello', name: 'hello')]
    public function index(): Response
    {
        $workflowClient = WorkflowClientProvider::instance();

        $demo = $workflowClient->newWorkflowStub(
            DemoWorkflowInterface::class,
            WorkflowOptions::new()
                ->withWorkflowExecutionTimeout(20)
        );

        $start = microtime(true);
        $result = $demo->run('Pavel', 1);

        dump([
            'result' => $result,
            'time' => microtime(true) - $start,
        ]);

        return new Response(
            serialize($result),
            200
        );
    }
}
