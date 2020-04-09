<?php

namespace Intacct\Functions\Common;

interface QueryFunctionInterface
{

    /**
     * @return string[]
     */
    public function getSelect();

    /**
     * @param string[] $fields
     */
    public function setSelect(array $fields);

    /**
     * @param string[] $fields
     *
     * @return QueryFunctionInterface
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
     * @param string $objectName
     *
     * @return QueryFunctionInterface
     */
    public function from(string $objectName);

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

    /**
     * @param string $docparid
     *
     */
    public function setDocparid($docparid);

    /**
     * @return string
     */
    public function getDocparid();

    /**
     * @param $docparid
     *
     * @return QueryFunctionInterface
     */
    public function docparid($docparid);

    /**
     * @return OrderByInterface
     */
    public function getOrderBy() : OrderByInterface;

    /**
     * @param OrderByInterface $orderBy
     */
    public function setOrderBy(OrderByInterface $orderBy) : void;

    /**
     * @param $orderBy
     *
     * @return QueryFunctionInterface
     */
    public function orderBy($orderBy);

    /**
     * @return bool
     */
    public function isCaseInsensitive() : bool;

    /**
     * @param bool $caseInsensitive
     */
    public function setCaseInsensitive(bool $caseInsensitive) : void;

    /**
     * @param bool $caseInsensitive
     *
     * @return QueryFunctionInterface
     */
    public function caseinsensitive(bool $caseInsensitive);

    /**
     * @return int
     */
    public function getPagesize() : int;

    /**
     * @param int $pagesize
     */
    public function setPageSize(int $pagesize) : void;

    /**
     * @param int $pagesize
     *
     * @return QueryFunctionInterface
     */
    public function pagesize(int $pagesize);

    /**
     * @return int
     */
    public function getOffset() : int;

    /**
     * @param int $offset
     */
    public function setOffset(int $offset) : void;

    /**
     * @param int $offset
     *
     * @return QueryFunctionInterface
     */
    public function offset(int $offset);

}