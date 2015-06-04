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
 * All pagination systems should implement of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface PaginationInterface extends \Countable, \Iterator, \ArrayAccess
{
    /**
     * Paginate
     *
     * @param mixed   $query
     * @param integer $page
     * @param integer $limit
     */
    public function paginate($query, $page, $limit);

    /**
     * Get limit (Count elements per page)
     *
     * @return int
     */
    public function getLimit();

    /**
     * Get active page
     *
     * @return int
     */
    public function getPage();

    /**
     * Get full count elements
     *
     * @return int
     */
    public function getFullCount();
}
