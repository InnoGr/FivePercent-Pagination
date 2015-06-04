<?php

/**
 * This file is part of the Pagination package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Pagination\Doctrine\ORM;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use FivePercent\Component\Pagination\AbstractPagination;
use FivePercent\Component\Pagination\Exception\InvalidQueryException;

/**
 * Paginate Doctrine ORM Query
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class DefaultPagination extends AbstractPagination
{
    /**
     * {@inheritDoc}
     */
    protected function doProxyPaginate()
    {
        if (!$this->query) {
            throw new \RuntimeException('Please enter the query for paginate.');
        }

        $query = $this->query;

        if ($query instanceof QueryBuilder) {
            $query = $query->getQuery();
        }

        if (!$query instanceof Query) {
            throw new InvalidQueryException(sprintf(
                'The query must be Doctrine\ORM\Query instance, but "%s" given.',
                is_object($query) ? get_class($query) : gettype($query)
            ));
        }

        $this->storage = $query
            ->setMaxResults($this->limit)
            ->setFirstResult($this->limit * $this->page - $this->limit)
            ->getResult();

        if (count($this->storage) > 0) {
            $doctrinePagination = new Paginator($query);
            $this->fullCount = $doctrinePagination->count();
            unset ($doctrinePagination);
        } else {
            $this->fullCount = 0;
        }
    }
}
