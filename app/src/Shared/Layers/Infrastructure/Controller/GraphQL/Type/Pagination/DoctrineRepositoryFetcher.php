<?php

namespace Finconsult\Documentor\Shared\Layers\Infrastructure\Controller\GraphQL\Type\Pagination;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;

class DoctrineRepositoryFetcher implements FetcherInterface
{
    public function __construct(
        private ServiceEntityRepository $repository,
        private ?Criteria $criteria = null
    ) {
    }

    public function getFetcher(): callable
    {
        return function ($offset, $limit) {
            return $this->criteria instanceof Criteria ?
                $this->repository->matching($this->criteria)->slice($offset, $limit) :
                $this->repository->findBy([], [], $limit, $offset);
        };
    }

    public function getCounter(): callable
    {
        return function () {
            return $this->criteria instanceof Criteria ?
                $this->repository->matching($this->criteria)->count() :
                $this->repository->count([]);
        };
    }
}
