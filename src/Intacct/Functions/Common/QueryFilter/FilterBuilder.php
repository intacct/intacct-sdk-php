<?php

namespace Intacct\Functions\Common\QueryFilter;

class FilterBuilder implements FilterBuilderInterface
{

    /**
     * @var array
     */
    private $_conditionSet;

    /**
     * FilterBuilder constructor.
     */
    public function __construct()
    {
        $this->_conditionSet = [];
    }

    /**
     * @param FilterInterface[] $filters
     *
     * @return FilterBuilderInterface
     */
    public function and($filters) : FilterBuilderInterface
    {
        $_currentConditionSet = new AndCondition($filters);
        $this->_conditionSet[] = $_currentConditionSet;

        return $this;
    }

    /**
     * @param FilterInterface[] $filters
     *
     * @return FilterBuilderInterface
     */
    public function or($filters) : FilterBuilderInterface
    {
        $_currentConditionSet = new OrCondition($filters);
        $this->_conditionSet[] = $_currentConditionSet;

        return $this;
    }

    /**
     * @return FilterInterface[]
     */
    public function getFilters() : array
    {
        return $this->_conditionSet;
    }
}