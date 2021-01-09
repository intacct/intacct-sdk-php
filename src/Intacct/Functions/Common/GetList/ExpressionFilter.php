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

class ExpressionFilter implements FilterInterface
{

    /** @var string */
    const OPERATOR_EQUAL_TO = '=';

    /** @var string */
    const OPERATOR_NOT_EQUAL_TO = '!=';

    /** @var string */
    const OPERATOR_LESS_THAN = '<';

    /** @var string */
    const OPERATOR_LESS_THAN_OR_EQUAL_TO = '<=';

    /** @var string */
    const OPERATOR_GREATER_THAN = '>';

    /** @var string */
    const OPERATOR_GREATER_THAN_OR_EQUAL_TO = '>=';

    /** @var string */
    const OPERATOR_LIKE = 'like';

    /** @var string */
    const OPERATOR_NOT_LIKE = 'not like';

    /** @var string */
    const OPERATOR_IS_NULL = 'is null';

    /** @var string */
    protected $fieldName = '';

    /** @var string */
    protected $operator = '';

    /** @var mixed */
    protected $value = '';

    /** @var string */
    protected $objectName = '';

    /**
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @param string $fieldName
     */
    public function setFieldName(string $fieldName)
    {
        $this->fieldName = $fieldName;
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
            static::OPERATOR_EQUAL_TO,
            static::OPERATOR_NOT_EQUAL_TO,
            static::OPERATOR_GREATER_THAN,
            static::OPERATOR_GREATER_THAN_OR_EQUAL_TO,
            static::OPERATOR_LESS_THAN,
            static::OPERATOR_LESS_THAN_OR_EQUAL_TO,
            static::OPERATOR_LIKE,
            static::OPERATOR_NOT_LIKE,
            static::OPERATOR_IS_NULL,
        ];
        if (!in_array($operator, $operators)) {
            throw new \InvalidArgumentException('Expression Operator must be either: ' . implode(', ', $operators));
        }
        $this->operator = $operator;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
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
     * Write the expression block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('expression');
        if ($this->getObjectName()) {
            $xml->writeAttribute('object', $this->getObjectName());
        }

        if (!$this->getFieldName()) {
            throw new \InvalidArgumentException('Field Name is required for an expression filter');
        }
        $xml->writeElement('field', $this->getFieldName(), true);

        if (!$this->getOperator()) {
            throw new \InvalidArgumentException('Operator is required for an expression filter');
        }
        $xml->writeElement('operator', $this->getOperator(), true);
        $xml->writeElement('value', $this->getValue(), true);

        $xml->endElement(); //expression
    }
}
