<?php

namespace Finconsult\Documentor\Shared\Infrastructure\Controller\GraphQL\Type\Pagination;

use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Relay\Connection\ConnectionInterface;
use Overblog\GraphQLBundle\Relay\Connection\Paginator;

class PaginatorWrapper
{
    public static function paginate(
        Pagination $pagination,
        FetcherInterface $collectionPaginator
    ): ConnectionInterface {
        $paginator = new Paginator(
            $collectionPaginator->getFetcher(),
            Paginator::MODE_REGULAR,
            new ConnectionBuilder()
        );

        return $paginator->auto(
            new Argument($pagination->toArray()),
            $collectionPaginator->getCounter()
        );
    }
}
