<?php

namespace Finconsult\Documentor\Shared\Infrastructure\Controller\GraphQL\Type\Pagination;

use Overblog\GraphQLBundle\Definition\ArgumentInterface;
use Overblog\GraphQLBundle\Relay\Connection\ConnectionBuilder as OverblogConnectionBuilder;
use Overblog\GraphQLBundle\Relay\Connection\ConnectionInterface;
use Overblog\GraphQLBundle\Relay\Connection\EdgeInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\Edge;
use Overblog\GraphQLBundle\Relay\Connection\Output\PageInfo;
use Overblog\GraphQLBundle\Relay\Connection\PageInfoInterface;

/**
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
class ConnectionBuilder extends OverblogConnectionBuilder
{
    /**
     * Реализация ConnectionBuilder с исправленной пагинацией из Overblog\GraphQLBundle.
     *
     * {@inheritdoc}
     */
    public function connectionFromArraySlice(array $arraySlice, $args, array $meta): ConnectionInterface
    {
        $connectionArguments = $this->getOptionsWithDefaults(
            $args instanceof ArgumentInterface ? $args->getArrayCopy() : $args,
            [
                'after' => '',
                'before' => '',
                'first' => null,
                'last' => null,
            ]
        );
        $arraySliceMetaInfo = $this->getOptionsWithDefaults(
            $meta,
            [
                'sliceStart' => 0,
                'arrayLength' => 0,
            ]
        );

        $arraySliceLength = count($arraySlice);
        $after = $connectionArguments['after'];
        $before = $connectionArguments['before'];
        $first = $connectionArguments['first'];
        $last = $connectionArguments['last'];
        $sliceStart = $arraySliceMetaInfo['sliceStart'];
        $arrayLength = $arraySliceMetaInfo['arrayLength'];
        $sliceEnd = $sliceStart + $arraySliceLength;
        $beforeOffset = $this->getOffsetWithDefault($before, $arrayLength);
        $afterOffset = $this->getOffsetWithDefault($after, -1);

        $startOffset = max($sliceStart - 1, $afterOffset, -1) + 1;
        $endOffset = min($sliceEnd, $beforeOffset, $arrayLength);

        if (is_numeric($first)) {
            if ($first < 0) {
                throw new \InvalidArgumentException('Argument "first" must be a non-negative integer');
            }
            $endOffset = min($endOffset, $startOffset + $first);
        }

        if (is_numeric($last)) {
            if ($last < 0) {
                throw new \InvalidArgumentException('Argument "last" must be a non-negative integer');
            }
            $startOffset = max($startOffset, $endOffset - $last);
        }

        // If supplied slice is too large, trim it down before mapping over it.
        $offset = max($startOffset - $sliceStart, 0);
        $length = ($arraySliceLength - ($sliceEnd - $endOffset)) - $offset;

        $slice = array_slice(
            $arraySlice,
            $offset,
            $length
        );

        $edges = $this->createEdges($slice, $startOffset);

        $firstEdge = $edges[0] ?? null;
        $lastEdge = end($edges);
        $lowerBound = $after ? ($afterOffset + 1) : 0;
        $upperBound = $before ? $beforeOffset : $arrayLength;

        // Проверяем, есть ли элементы перед выбираемой нами частью коллекции
        $hasPreviousPage = false;
        if (null !== $last) {
            $hasPreviousPage = ($lowerBound > 0) ? $startOffset > 0 : $startOffset > $lowerBound;
        } elseif (null !== $first) {
            $hasPreviousPage = 0 !== $startOffset;
        }

        // Проверяем, есть ли элементы после выбираемой нами части коллекции
        $hasNextPage = false;
        if (null !== $first) {
            $hasNextPage = ($upperBound < $arrayLength) ? $endOffset < $arrayLength : $endOffset < $upperBound;
        } elseif (null !== $last) {
            $hasNextPage = $endOffset !== $arrayLength;
        }

        $pageInfo = new PageInfo(
            $firstEdge instanceof EdgeInterface ? $firstEdge->getCursor() : null,
            $lastEdge instanceof EdgeInterface ? $lastEdge->getCursor() : null,
            $hasPreviousPage,
            $hasNextPage
        );

        return $this->createConnection($edges, $pageInfo);
    }

    private function createEdges(iterable $slice, int $startOffset): array
    {
        $edges = [];

        foreach ($slice as $index => $value) {
            $cursor = $this->offsetToCursor($startOffset + $index);
            if ($this->edgeCallback) {
                $edge = ($this->edgeCallback)($cursor, $value, $index);
                if (!($edge instanceof EdgeInterface)) {
                    throw new \InvalidArgumentException('The $edgeCallback of the ConnectionBuilder must return an instance of EdgeInterface');
                }
            } else {
                $edge = new Edge($cursor, $value);
            }
            $edges[] = $edge;
        }

        return $edges;
    }

    /**
     * @param mixed $edges
     */
    private function createConnection($edges, PageInfoInterface $pageInfo): ConnectionInterface
    {
        if ($this->connectionCallback) {
            $connection = ($this->connectionCallback)($edges, $pageInfo);
            if (!($connection instanceof ConnectionInterface)) {
                throw new \InvalidArgumentException('The $connectionCallback of the ConnectionBuilder must return an instance of ConnectionInterface');
            }

            return $connection;
        }

        return new Connection($edges, $pageInfo);
    }

    private function getOptionsWithDefaults(array $options, array $defaults): array
    {
        return $options + $defaults;
    }
}
