<?php

namespace Finconsult\Documentor\Shared\Layers\Infrastructure\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RedirectingExceptionListener
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();
        $exception = $event->getThrowable();

        if (!$request->isXmlHttpRequest() && $exception instanceof NotFoundHttpException) {
            $response = new RedirectResponse($this->urlGenerator->generate('app_index'));
            $event->setResponse($response);
            $event->stopPropagation();
        }
    }
}
