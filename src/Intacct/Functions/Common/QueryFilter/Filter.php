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

namespace Intacct\Functions\Common\QueryFilter;

use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class Filter implements FilterInterface
{

    const EQUAL_TO = 'equalto';

    const NOT_EQUAL_TO = 'notequalto';

    const LESS_THAN = 'lessthan';

    const LESS_THAN_OR_EQUAL_TO = 'lessthanorequalto';

    const GREATER_THAN = 'greaterthan';

    const GREATER_THAN_OR_EQUAL_TO = 'greaterthanorequalto';

    const BETWEEN = 'between';

    const IN = 'in';

    const NOT_IN = 'notin';

    const LIKE = 'like';

    const NOT_LIKE = 'notlike';

    const IS_NULL = 'isnull';

    const IS_NOT_NULL = 'isnotnull';

    /**
     * @var string
     */
    private $_field;

    /**
     * @var string|string[]
     */
    private $_value;

    /**
     * @var string
     */
    private $_operation;

    /**
     * Filter constructor.
     *
     * @param string $fieldName
     */
    public function __construct(string $fieldName)
    {
        $this->_field = $fieldName;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function equalto(string $value)
    {
        $this->_value = $value;

        $this->_operation = self::EQUAL_TO;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function notequalto(string $value)
    {
        $this->_value = $value;

        $this->_operation = self::NOT_EQUAL_TO;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function lessthan(string $value)
    {
        $this->_value = $value;

        $this->_operation = self::LESS_THAN;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function lessthanorequalto(string $value)
    {
        $this->_value = $value;

        $this->_operation = self::LESS_THAN_OR_EQUAL_TO;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function greaterthan(string $value)
    {
        $this->_value = $value;

        $this->_operation = self::GREATER_THAN;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function greaterthanorequalto(string $value)
    {
        $this->_value = $value;

        $this->_operation = self::GREATER_THAN_OR_EQUAL_TO;

        return $this;
    }

    /**
     * @param string[] $value
     *
     * @return FilterInterface
     */
    public function between(array $value)
    {
        if ( ( $value ) && sizeof($value) != 2 ) {
            throw new InvalidArgumentException('Two strings expected for between filter');
        }
        $this->_value = $value;

        $this->_operation = self::BETWEEN;

        return $this;
    }

    /**
     * @param string[] $value
     *
     * @return FilterInterface
     */
    public function in(array $value)
    {
        $this->_value = $value;

        $this->_operation = self::IN;

        return $this;
    }

    /**
     * @param string[] $value
     *
     * @return FilterInterface
     */
    public function notin(array $value)
    {
        $this->_value = $value;

        $this->_operation = self::NOT_IN;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function like($value)
    {
        $this->_value = $value;

        $this->_operation = self::LIKE;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return FilterInterface
     */
    public function notlike($value)
    {
        $this->_value = $value;

        $this->_operation = self::NOT_LIKE;

        return $this;
    }

    /**
     * @return FilterInterface
     */
    public function isnull()
    {
        $this->_operation = self::IS_NULL;

        return $this;
    }

    /**
     * @return FilterInterface
     */
    public function isnotnull()
    {
        $this->_operation = self::IS_NOT_NULL;

        return $this;
    }

    /**
     * @param XMLWriter $xml
     *
     */
    public function writeXML(XMLWriter $xml)
    {
        $xml->startElement($this->_operation);

        $xml->writeElement('field', $this->_field, false);
        if ( $this->_value ) {
            if ( is_array($this->_value) ) {
                foreach ( $this->_value as $arrayValue ) {
                    $xml->writeElement('value', $arrayValue, false);
                }
            } else {
                $xml->writeElement('value', $this->_value, false);
            }
        }

        $xml->endElement(); //close tag for $this->_operation
    }
}