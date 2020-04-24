<?php

namespace Intacct\Functions\Common\QueryFilter;

interface FilterBuilderInterface
{

    /**
     * @param FilterInterface[] $filters
     *
     * @return FilterBuilderInterface
     */
    public function and($filters) : FilterBuilderInterface;

    /**
     * @param FilterInterface[] $filters
     *
     * @return FilterBuilderInterface
     */
    public function or($filters) : FilterBuilderInterface;

    /**
     * @return FilterInterface[]
     */
    public function getFilters() : array;
}