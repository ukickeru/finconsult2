<?php

namespace Finconsult\Documentor\Shared\Infrastructure\Controller\GraphQL\Type\Pagination;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class ArrayFetcher implements FetcherInterface
{
    private ArrayCollection $collection;

    public function __construct(
        array $collection,
        private ?Criteria $criteria = null
    ) {
        $this->collection = new ArrayCollection($collection);
    }

    public function getFetcher(): callable
    {
        return function ($offset, $limit) {
            return $this->criteria instanceof Criteria ?
                $this->collection->matching($this->criteria)->slice($offset, $limit) :
                $this->collection->slice($offset, $limit);
        };
    }

    public function getCounter(): callable
    {
        return function () {
            return $this->criteria instanceof Criteria ?
                $this->collection->matching($this->criteria)->count() :
                $this->collection->count();
        };
    }
}
