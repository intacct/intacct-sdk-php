<?php

/**
 * Copyright 2020 Sage Intacct, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"). You may not
 * use this file except in compliance with the License. You may obtain a copy
 * of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Intacct\Functions\Common;

use Intacct\Functions\Common\QueryFilter\FilterInterface;
use Intacct\Functions\Common\QueryOrderBy\OrderInterface;
use Intacct\Functions\Common\QuerySelect\SelectInterface;
use Intacct\Xml\XMLWriter;

interface QueryFunctionInterface
{

    /**
     * @return SelectInterface[]
     *
     */
    public function getSelect();

    /**
     * @param SelectInterface[] $fields
     */
    public function setSelect(array $fields);

    /**
     * @param SelectInterface[] $fields
     *
     * @return QueryFunctionInterface
     */
    public function select(array $fields);

    /**
     * @return string
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
     * @param string $docparid
     *
     */
    public function setDocparid($docparid);

    /**
     * @return string|null
     */
    public function getDocparid();

    /**
     * @param $docparid
     *
     * @return QueryFunctionInterface
     */
    public function docparid($docparid);

    /**
     * @return FilterInterface|null
     */
    public function getFilter();

    /**
     * @param FilterInterface $filter
     */
    public function setFilter($filter);

    /**
     * @param FilterInterface $filter
     *
     * @return QueryFunctionInterface
     */
    public function filter($filter);

    /**
     * @return OrderInterface[]|null
     */
    public function getOrderBy();

    /**
     * @param OrderInterface[] $orderBy
     */
    public function setOrderBy($orderBy);

    /**
     * @param OrderInterface[] $orderBy
     *
     * @return QueryFunctionInterface
     */
    public function orderBy($orderBy);

    /**
     * @return bool|null
     */
    public function isCaseInsensitive();

    /**
     * @param bool $caseInsensitive
     */
    public function setCaseInsensitive(bool $caseInsensitive);

    /**
     * @param bool $caseInsensitive
     *
     * @return QueryFunctionInterface
     */
    public function caseinsensitive(bool $caseInsensitive);

    /**
     * @return int|null
     */
    public function getPagesize();

    /**
     * @param int $pagesize
     */
    public function setPageSize(int $pagesize);

    /**
     * @param int $pagesize
     *
     * @return QueryFunctionInterface
     */
    public function pagesize(int $pagesize);

    /**
     * @return int|null
     */
    public function getOffset();

    /**
     * @param int $offset
     */
    public function setOffset(int $offset);

    /**
     * @param int $offset
     *
     * @return QueryFunctionInterface
     */
    public function offset(int $offset);

    /**
     * @param XMLWriter $xml
     *
     * @return mixed
     */
    function writeXML(XMLWriter $xml);
}