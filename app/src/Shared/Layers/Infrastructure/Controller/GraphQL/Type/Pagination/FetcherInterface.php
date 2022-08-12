<?php

namespace Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\Type\Pagination;

interface FetcherInterface
{
    public function getFetcher(): callable;

    public function getCounter(): callable;
}
