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

use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class Filter implements FilterInterface
{

    /** @var string */
    const EQUAL_TO = 'equalto';

    /** @var string */
    const NOT_EQUAL_TO = 'notequalto';

    /** @var string */
    const LESS_THAN = 'lessthan';

    /** @var string */
    const LESS_THAN_OR_EQUAL_TO = 'lessthanorequalto';

    /** @var string */
    const GREATER_THAN = 'greaterthan';

    /** @var string */
    const GREATER_THAN_OR_EQUAL_TO = 'greaterthanorequalto';

    /** @var string */
    const BETWEEN = 'between';

    /** @var string */
    const IN = 'in';

    /** @var string */
    const NOT_IN = 'notin';

    /** @var string */
    const LIKE = 'like';

    /** @var string */
    const NOT_LIKE = 'notlike';

    /** @var string */
    const IS_NULL = 'isnull';

    /** @var string */
    const IS_NOT_NULL = 'isnotnull';

    /** @var string */
    private $field;

    /** @var string|string[] */
    private $value;

    /** @var string */
    private $operation;

    /**
     * Filter constructor.
     *
     * @param string $fieldName
     */
    public function __construct(string $fieldName)
    {
        $this->field = $fieldName;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function equalTo(string $value): FilterInterface
    {
        $this->value = $value;

        $this->operation = self::EQUAL_TO;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function notEqualTo(string $value): FilterInterface
    {
        $this->value = $value;

        $this->operation = self::NOT_EQUAL_TO;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function lessThan(string $value): FilterInterface
    {
        $this->value = $value;

        $this->operation = self::LESS_THAN;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function lessThanOrEqualTo(string $value): FilterInterface
    {
        $this->value = $value;

        $this->operation = self::LESS_THAN_OR_EQUAL_TO;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function greaterThan(string $value): FilterInterface
    {
        $this->value = $value;

        $this->operation = self::GREATER_THAN;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function greaterThanOrEqualTo(string $value): FilterInterface
    {
        $this->value = $value;

        $this->operation = self::GREATER_THAN_OR_EQUAL_TO;

        return $this;
    }

    /**
     * @param string[] $value
     *
     * @return FilterInterface
     * @throws InvalidArgumentException
     */
    public function between(array $value): FilterInterface
    {
        if (($value) && (sizeof($value) !== 2)) {
            throw new InvalidArgumentException('Two strings expected for between filter');
        }
        $this->value = $value;

        $this->operation = self::BETWEEN;

        return $this;
    }

    /**
     * @param string[] $value
     *
     * @return FilterInterface
     */
    public function in(array $value): FilterInterface
    {
        $this->value = $value;

        $this->operation = self::IN;

        return $this;
    }

    /**
     * @param string[] $value
     *
     * @return FilterInterface
     */
    public function notIn(array $value): FilterInterface
    {
        $this->value = $value;

        $this->operation = self::NOT_IN;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function like($value): FilterInterface
    {
        $this->value = $value;

        $this->operation = self::LIKE;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function notLike($value): FilterInterface
    {
        $this->value = $value;

        $this->operation = self::NOT_LIKE;

        return $this;
    }

    /**
     * @return FilterInterface
     */
    public function isNull(): FilterInterface
    {
        $this->operation = self::IS_NULL;

        return $this;
    }

    /**
     * @return FilterInterface
     */
    public function isNotNull(): FilterInterface
    {
        $this->operation = self::IS_NOT_NULL;

        return $this;
    }

    /**
     * @param XMLWriter &$xml
     */
    public function writeXML(XMLWriter &$xml)
    {
        $xml->startElement($this->operation);

        $xml->writeElement('field', $this->field, false);
        if ($this->value) {
            if (is_array($this->value)) {
                foreach ($this->value as $arrayValue) {
                    $xml->writeElement('value', $arrayValue, false);
                }
            } else {
                $xml->writeElement('value', $this->value, false);
            }
        }

        $xml->endElement(); //close tag for $this->_operation
    }
}