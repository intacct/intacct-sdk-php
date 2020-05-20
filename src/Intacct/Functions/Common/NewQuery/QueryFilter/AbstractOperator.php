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

namespace Intacct\Functions\Common\NewQuery\QueryFilter;

use Intacct\Xml\XMLWriter;

abstract class AbstractOperator implements FilterInterface
{

    const OR = 'or';
    const AND = 'and';

    /**
     * @param FilterInterface[] $_filters
     */
    private $_filters;

    /**
     * AbstractOperator constructor.
     *
     * @param FilterInterface[]|null $filters
     */
    public function __construct($filters)
    {
        $this->_filters = $filters;
    }

    /**
     * @param FilterInterface $filter
     *
     * @return FilterInterface
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->_filters[] = $filter;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getOperator() : string;

    /**
     * @param XMLWriter &$xml
     */
    public function writeXML(XMLWriter &$xml)
    {
        if ( ( $this->_filters ) && ( sizeof($this->_filters) >= 2 ) ) {
            $xml->startElement($this->getOperator());
            foreach ( $this->_filters as $filter ) {
                $filter->writeXML($xml);
            }
            $xml->endElement(); //and/or
        } else {
            throw new \Exception("Two or more FilterInterface objects required for " . $this->getOperator());
        }
    }
}