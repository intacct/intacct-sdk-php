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

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Common\QueryFilter\FilterInterface;
use Intacct\Functions\Common\QueryOrderBy\OrderInterface;
use Intacct\Functions\Common\QuerySelect\SelectInterface;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class Query extends AbstractFunction implements QueryFunctionInterface
{

    /**
     * @var SelectInterface[]
     */
    private $_selectFields;

    /**
     * @var string
     */
    private $_fromObject;

    /**
     * @var string
     */
    private $_docparid;

    /**
     * @var FilterInterface[]
     */
    private $_filters;

    /**
     * @var OrderInterface[]
     */
    private $_orderBy;

    /**
     * @var bool
     */
    private $_caseInsensitive;

    /**
     * @var int
     */
    private $_pagesize;

    /**
     * @var int
     */
    private $_offset;

    /**
     * @return SelectInterface[]
     */
    public function getSelect()
    {
        return $this->_selectFields;
    }

    /**
     * @param SelectInterface[] $fields
     */
    public function setSelect(array $fields)
    {
        if ( ! $fields ) {
            throw new InvalidArgumentException('Field name for select cannot be empty or null. Provide Field name for select in array.');
        }

        $this->_selectFields = $fields;
    }

    /**
     * @param SelectInterface[] $fields
     *
     * @return QueryFunctionInterface
     */
    public function select(array $fields)
    {
        $this->setSelect($fields);

        return $this;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->_fromObject;
    }

    /**
     * @param string $objectName
     */
    public function setFrom(string $objectName)
    {
        if ( $objectName && $objectName != "" ) {
            $this->_fromObject = $objectName;
        } else {
            throw new InvalidArgumentException('Object name for setting from cannot be empty or null. Set object name using from setter.');
        }
    }

    /**
     * @param string $objectName
     *
     * @return QueryFunctionInterface
     */
    public function from(string $objectName)
    {
        $this->setFrom($objectName);

        return $this;
    }

    /**
     * @param string $docparid
     *
     */
    public function setDocparid($docparid)
    {
        if ( $docparid && $docparid != '' ) { // flip these
            $this->_docparid = $docparid;
        } else {
            throw new InvalidArgumentException('docparid cannot be empty. Set docparid with valid document identifier.');
        }
    }

    /**
     * @return string|null
     */
    public function getDocparid()
    {
        return $this->_docparid;
    }

    /**
     * @param $docparid
     *
     * @return QueryFunctionInterface
     */
    public function docparid($docparid)
    {
        $this->setDocparid($docparid);

        return $this;
    }

    /**
     * @return FilterInterface[]|null
     */
    public function getFilters()
    {
        return $this->_filters;
    }

    /**
     * @param FilterInterface[] $filters
     */
    public function setFilters($filters) : void
    {
        $this->_filters = $filters;
    }

    /**
     * @param FilterInterface[] $filters
     *
     * @return QueryFunctionInterface
     */
    public function filter($filters)
    {
        $this->setFilters($filters);

        return $this;
    }

    /**
     * @return OrderInterface[]|null
     */
    public function getOrderBy()
    {
        return $this->_orderBy;
    }

    /**
     * @param OrderInterface[] $orderBy
     */
    public function setOrderBy($orderBy) : void
    {
        if ( ! $orderBy ) {
            throw new InvalidArgumentException('Field name for orderBy cannot be empty or null. Provide orders for orderBy in array.');
        }

        $this->_orderBy = $orderBy;
    }

    /**
     * @param OrderInterface[] $orderBy
     *
     * @return QueryFunctionInterface
     */
    public function orderBy($orderBy)
    {
        $this->setOrderBy($orderBy);

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isCaseInsensitive()
    {
        return $this->_caseInsensitive;
    }

    /**
     * @param bool $caseInsensitive
     */
    public function setCaseInsensitive(bool $caseInsensitive) : void
    {
        $this->_caseInsensitive = $caseInsensitive;
    }

    /**
     * @param bool $caseInsensitive
     *
     * @return QueryFunctionInterface
     */
    public function caseinsensitive(bool $caseInsensitive)
    {
        $this->setCaseInsensitive($caseInsensitive);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPagesize()
    {
        return $this->_pagesize;
    }

    /**
     * @param int $pagesize
     */
    public function setPageSize(int $pagesize) : void
    {
        if ( $pagesize < 0 ) {
            throw new InvalidArgumentException('pagesize cannot be negative. Set pagesize greater than zero.');
        }

        $this->_pagesize = $pagesize;
    }

    /**
     * @param int $pagesize
     *
     * @return QueryFunctionInterface
     */
    public function pagesize(int $pagesize)
    {
        $this->setPageSize($pagesize);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOffset()
    {
        return $this->_offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset) : void
    {
        if ( $offset < 0 ) {
            throw new InvalidArgumentException('offset cannot be negative. Set offset to zero or greater than zero.');
        }

        $this->_offset = $offset;
    }

    /**
     * @param int $offset
     *
     * @return QueryFunctionInterface
     */
    public function offset(int $offset)
    {
        $this->setOffset($offset);

        return $this;
    }

    /**
     * @param XMLWriter $xml
     */
    public function writeXML(XMLWriter $xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('query');

        if ( ! $this->getSelect() ) {
            throw new InvalidArgumentException('Select fields are required for query; set through method select setter.');
        }

        $xml->startElement('select');
        foreach ( $this->getSelect() as $_field ) {
            $_field->writeXML($xml);
        }
        $xml->endElement(); // select

        if ( ! $this->getFrom() ) {
            throw new InvalidArgumentException('Object Name is required for query; set through method from setter.');
        }

        $xml->writeElement('object', $this->getFrom(), false);

        if ( $this->getDocparid() ) {
            $xml->writeElement('docparid', $this->getDocparid(), false);
        }

        if ( $this->getFilters() ) {
            $xml->startElement('filter');

            foreach ( $this->getFilters() as $filter ) {
                $filter->writeXML($xml);
            }

            $xml->endElement();
        }

        if ( $this->getOrderBy() ) {
            $xml->startElement('orderby');
            foreach ( $this->getOrderBy() as $order ) {
                $order->writeXML($xml);
            }
            $xml->endElement(); // orderby
        }

        if ( $this->isCaseInsensitive() ) {
            $xml->startElement('options');
            $xml->writeElement('caseinsensitive', $this->isCaseInsensitive(), false);
            $xml->endElement();
        }

        if ( $this->getPagesize() ) {
            $xml->writeElement('pagesize', $this->getPagesize(), false);
        }

        if ( $this->getOffset() ) {
            $xml->writeElement('offset', $this->getOffset(), false);
        }

        $xml->endElement(); //query

        $xml->endElement(); //function
    }
}