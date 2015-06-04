<?php

/**
 * This file is part of the Pagination package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Pagination;

/**
 * Abstract pagination system
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
abstract class AbstractPagination implements PaginationInterface
{
    /**
     * @var mixed
     */
    protected $query;

    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var array
     */
    protected $storage;

    /**
     * @var int
     */
    protected $fullCount;

    /**
     * @var bool
     */
    private $paginated;

    /**
     * {@inheritDoc}
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * {@inheritDoc}
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * {@inheritDoc}
     */
    public function getFullCount()
    {
        return $this->fullCount;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        $this->proxyPaginate();

        return count($this->storage);
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        $this->proxyPaginate();

        return current($this->storage);
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        $this->proxyPaginate();

        return next($this->storage);
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        $this->proxyPaginate();

        return key($this->storage);
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        $this->proxyPaginate();

        return key($this->storage) !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->proxyPaginate();

        reset($this->storage);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset)
    {
        $this->proxyPaginate();

        return isset($this->storage[$offset]);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        $this->proxyPaginate();

        return $this->storage[$offset];
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->proxyPaginate();

        if (null === $offset) {
            $this->storage[] = $value;
        } else {
            $this->storage[$offset] = $value;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
        $this->proxyPaginate();

        unset ($this->storage[$offset]);
    }

    /**
     * Paginate
     *
     * @param mixed $query
     * @param integer $page
     * @param integer $limit
     *
     * @return PaginationInterface
     */
    public function paginate($query, $page, $limit)
    {
        $this->query = $query;
        $this->page = $page;
        $this->limit = $limit;

        return $this;
    }

    /**
     * Proxy pagination.
     * Can not be override! If your want change paginate logic, please
     * override "doProxyPaginate" method.
     */
    final protected function proxyPaginate()
    {
        if ($this->paginated) {
            return;
        }

        $this->paginated = true;

        $this->doProxyPaginate();
    }

    /**
     * Do proxy paginate
     * Self process of paginate. Must be set count items or another variables.
     * This method must be overriding!
     */
    abstract protected function doProxyPaginate();
}
