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
     * @var FilterBuilderInterface
     */
    private $_filter;

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
            throw new InvalidArgumentException('Fields for select cannot be empty or null. Provide fields for select in array.');
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
     * @return FilterBuilderInterface
     */
    public function getFilter() : FilterBuilderInterface
    {
        return $this->_filter;
    }

    /**
     * @param FilterBuilderInterface $filter
     */
    public function setFilter(FilterBuilderInterface $filter)
    {
        $this->_filter = $filter;
    }

    /**
     * @param FilterBuilderInterface $filter
     *
     * @return QueryFunctionInterface
     */
    public function where(FilterBuilderInterface $filter)
    {
        $this->_filter = $filter;

        return $this;
    }

    /**
     * @param string $docparid
     *
     */
    public function setDocparid($docparid)
    {
        if ( $docparid && $docparid != '' ) {
            $this->_docparid = $docparid;
        } else {
            throw new InvalidArgumentException('docparid cannot be empty. Set docparid with valid document identifier.');
        }
    }

    /**
     * @return string
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
     * @return OrderInterface[]
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
            throw new InvalidArgumentException('Fields for orderBy cannot be empty or null. Provide orders for orderBy in array.');
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
     * @return bool
     */
    public function isCaseInsensitive() : bool
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
     * @return int
     */
    public function getPagesize() : int
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
     * @return int
     */
    public function getOffset() : int
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

        if ( ! $this->_selectFields ) {
            throw new InvalidArgumentException('Select fields are required for query; set through method select setter.');
        }

        $xml->startElement('select');
        foreach ( $this->_selectFields as $_field ) {
            $_field->writeXML($xml);
        }
        $xml->endElement(); // select

        if ( ! $this->_fromObject ) {
            throw new InvalidArgumentException('Object Name is required for query; set through method from setter.');
        }

        $xml->writeElement('object', $this->_fromObject, false);

        if ( $this->_docparid ) {
            $xml->writeElement('docparid', $this->_docparid, false);
        }

        if ( $this->_filter ) {
            $xml->writeElement('filter', $this->_filter, false);
        }

        if ( $this->_orderBy ) {
            $xml->startElement('orderby');
            foreach ( $this->_orderBy as $order ) {
                $order->writeXML($xml);
            }
            $xml->endElement(); // orderby
        }

        if ( $this->_caseInsensitive ) {
            $xml->startElement('options');
            $xml->writeElement('caseinsensitive', $this->_caseInsensitive, false);
            $xml->endElement();
        }

        if ( $this->_pagesize ) {
            $xml->writeElement('pagesize', $this->_pagesize, false);
        }

        if ( $this->_offset ) {
            $xml->writeElement('offset', $this->_offset, false);
        }

        $xml->endElement(); //query

        $xml->endElement(); //function
    }
}