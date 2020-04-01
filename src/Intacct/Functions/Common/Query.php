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
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class Query extends AbstractFunction implements QueryFunctionInterface
{

    /**
     * @var string[]
     */
    private $_selectFields;

    /**
     * @var string[]
     */
    private $_fromObject;

    /**
     * @var FilterBuilderInterface
     */
    private $_filter;

    /**
     * @return string[]
     */
    public function getSelect()
    {
        return $this->_selectFields;
    }

    /**
     * @param array $fields
     */
    public function setSelect(array $fields)
    {
        $this->_selectFields = $fields;
    }

    /**
     * @param string[] $fields
     *
     * @return $this
     */
    public function select(array $fields)
    {
        $this->setSelect($fields);

        return $this;
    }

    /**
     * @return string[]
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
        $this->setFrom($objectName);
    }

    /**
     * @param $objectName
     *
     * @return $this
     */
    public function from($objectName)
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
     *
     * @return string
     */
    private function writeXMLFields() : string
    {
        return "";
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
            throw new InvalidArgumentException('Select fields are required for query; set through select()');
        }
        $xml->writeElement('select', $this->_selectFields, false);

        if ( ! $this->_fromObject ) {
            throw new InvalidArgumentException('Object Name is required for query; set through from()');
        }
        $xml->writeElement('object', $this->_fromObject, false);

        $xml->endElement(); //query

        $xml->endElement(); //function
    }
}