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

namespace Intacct\Functions\Common\GetList;

use Intacct\Xml\XMLWriter;

class LogicalFilter implements FilterInterface
{

    /** @var string */
    const OPERATOR_AND = 'and';

    /** @var string */
    const OPERATOR_OR = 'or';

    /** @var FilterInterface[] */
    protected $filters = [];

    /** @var string */
    protected $operator = '';

    /** @var string */
    protected $objectName = '';

    /**
     * @return FilterInterface[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param FilterInterface[] $filters
     */
    public function setFilters(array $filters)
    {
        if (count($filters) < 2) {
            throw new \InvalidArgumentException('Logical Filters count must be 2 or more');
        }
        $this->filters = $filters;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     */
    public function setOperator(string $operator)
    {
        $operators = [
            static::OPERATOR_AND,
            static::OPERATOR_OR,
        ];
        if (!in_array($operator, $operators)) {
            throw new \InvalidArgumentException('Logical Operator must be either:' . implode(', ', $operators));
        }
        $this->operator = $operator;
    }

    /**
     * @return string
     */
    public function getObjectName(): string
    {
        return $this->objectName;
    }

    /**
     * @param string $objectName
     */
    public function setObjectName(string $objectName)
    {
        $this->objectName = $objectName;
    }

    /**
     * Write the logical block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('logical');
        $xml->writeAttribute('logical_operator', $this->getOperator());
        if ($this->getObjectName()) {
            $xml->writeAttribute('object', $this->getObjectName());
        }

        if (count($this->getFilters()) < 2) {
            throw new \InvalidArgumentException('Logical Filters count must be 2 or more');
        }
        foreach ($this->getFilters() as $filter) {
            $filter->writeXml($xml);
        }

        $xml->endElement(); //logical
    }
}
