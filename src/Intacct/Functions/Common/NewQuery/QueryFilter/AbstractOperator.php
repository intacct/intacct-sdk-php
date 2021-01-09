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

namespace Intacct\Functions\Common\NewQuery\QueryFilter;

use Intacct\Exception\IntacctException;
use Intacct\Xml\XMLWriter;

abstract class AbstractOperator implements FilterInterface
{

    /** @var string */
    const OR = 'or';

    /** @var string */
    const AND = 'and';

    /**
     * @var FilterInterface[] $filters
     */
    private $filters;

    /**
     * AbstractOperator constructor.
     *
     * @param FilterInterface[]|null $filters
     */
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
     * @param FilterInterface $filter
     *
     * @return FilterInterface
     */
    public function addFilter(FilterInterface $filter): FilterInterface
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getOperator(): string;

    /**
     * @param XMLWriter &$xml
     * @throws IntacctException
     */
    public function writeXML(XMLWriter &$xml)
    {
        if (($this->filters) && (sizeof($this->filters) >= 2)) {
            $xml->startElement($this->getOperator());
            foreach ($this->filters as $filter) {
                $filter->writeXML($xml);
            }
            $xml->endElement(); //and/or
        } else {
            throw new IntacctException("Two or more FilterInterface objects required for " . $this->getOperator());
        }
    }
}