<?php

namespace Intacct\Functions\Common;

interface QueryFunctionInterface
{

    /**
     * @return string[]
     */
    public function getSelect();

    /**
     * @param array $fields
     */
    public function setSelect(array $fields);

    /**
     * @param string[] $fields
     *
     * @return $this
     */
    public function select(array $fields);

    /**
     * @return string[]
     */
    public function getFrom();

    /**
     * @param string $objectName
     */
    public function setFrom(string $objectName);

    /**
     * @param $objectName
     *
     * @return $this
     */
    public function from($objectName);

    /**
     * @return FilterBuilderInterface
     */
    public function getFilter() : FilterBuilderInterface;

    /**
     * @param FilterBuilderInterface $filter
     */
    public function setFilter(FilterBuilderInterface $filter);

    /**
     * @param FilterBuilderInterface $filter
     *
     * @return QueryFunctionInterface
     */
    public function where(FilterBuilderInterface $filter);
}