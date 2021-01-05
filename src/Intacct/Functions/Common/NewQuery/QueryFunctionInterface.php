<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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

namespace Intacct\Functions\Common\NewQuery;

use Intacct\Functions\Common\NewQuery\QueryFilter\FilterInterface;
use Intacct\Functions\Common\NewQuery\QueryOrderBy\OrderInterface;
use Intacct\Functions\Common\NewQuery\QuerySelect\SelectInterface;
use Intacct\Xml\XMLWriter;

interface QueryFunctionInterface
{

    /**
     * @return SelectInterface[]|null
     */
    public function getSelect(); //: ?array;

    /**
     * @param SelectInterface[] $fields
     */
    public function setSelect(array $fields);

    /**
     * @param SelectInterface[] $fields
     * @return QueryFunctionInterface
     */
    public function select(array $fields): QueryFunctionInterface;

    /**
     * @return string|null
     */
    public function getFrom(); //: ?string

    /**
     * @param string $objectName
     */
    public function setFrom(string $objectName);

    /**
     * @param string $objectName
     * @return QueryFunctionInterface
     */
    public function from(string $objectName): QueryFunctionInterface;

    /**
     * @param string $docParId
     */
    public function setDocParId($docParId);

    /**
     * @return string|null
     */
    public function getDocParId(); //: ?string

    /**
     * @param $docParId
     * @return QueryFunctionInterface
     */
    public function docParId($docParId): QueryFunctionInterface;

    /**
     * @return FilterInterface|null
     */
    public function getFilter(); //:FilterInterface|null

    /**
     * @param FilterInterface $filter
     */
    public function setFilter($filter);

    /**
     * @param FilterInterface $filter
     * @return QueryFunctionInterface
     */
    public function filter($filter): QueryFunctionInterface;

    /**
     * @return OrderInterface[]|null
     */
    public function getOrderBy(); //: ?array

    /**
     * @param OrderInterface[] $orderBy
     */
    public function setOrderBy($orderBy);

    /**
     * @param OrderInterface[] $orderBy
     * @return QueryFunctionInterface
     */
    public function orderBy($orderBy): QueryFunctionInterface;

    /**
     * @return bool|null
     */
    public function isCaseInsensitive(); //: ?bool

    /**
     * @param bool $caseInsensitive
     */
    public function setCaseInsensitive(bool $caseInsensitive);

    /**
     * @param bool $caseInsensitive
     * @return QueryFunctionInterface
     */
    public function caseInsensitive(bool $caseInsensitive): QueryFunctionInterface;

    /**
     * @return int|null
     */
    public function getPageSize(); //: ?int

    /**
     * @param int $pageSize
     */
    public function setPageSize(int $pageSize);

    /**
     * @param int $pageSize
     * @return QueryFunctionInterface
     */
    public function pageSize(int $pageSize): QueryFunctionInterface;

    /**
     * @return int|null
     */
    public function getOffset(); //: ?int

    /**
     * @param int $offset
     */
    public function setOffset(int $offset);

    /**
     * @param int $offset
     * @return QueryFunctionInterface
     */
    public function offset(int $offset): QueryFunctionInterface;

    /**
     * @param XMLWriter $xml
     */
    public function writeXML(XMLWriter &$xml);
}