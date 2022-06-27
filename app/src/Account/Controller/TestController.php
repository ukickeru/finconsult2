<?php

namespace Finconsult\Documentor\Account\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Temporal\Client\WorkflowClient;

class TestController extends AbstractController
{
    #[Route(path: '/test', name: 'test')]
    public function test(WorkflowClient $workflowClient): Response
    {
        var_dump($workflowClient);

        return new Response(
            'Successfully tested! :) Autowiring and contexts works normally, WorkflowClient have been created! :D'
        );
    }
}
