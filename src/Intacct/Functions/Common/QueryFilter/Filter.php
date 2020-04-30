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

use Intacct\Xml\XMLWriter;

class Filter implements FilterInterface
{

    const EQUAL_TO = 'equalto';

    const LESS_THAN_OR_EQUAL_TO = 'lessthanorequalto';

    const GREATER_THAN_OR_EQUAL_TO = 'greaterthanorequalto';

    const IS_NULL = 'isnull';

    /**
     * @var string
     */
    private $_field;

    /**
     * @var string
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
    public function greaterthanorequalto(string $value)
    {
        $this->_value = $value;

        $this->_operation = self::GREATER_THAN_OR_EQUAL_TO;

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
     * @param XMLWriter $xml
     *
     */
    public function writeXML(XMLWriter $xml)
    {
        $xml->startElement($this->_operation);

        $xml->writeElement('field', $this->_field, false);
        if ( $this->_value ) {
            $xml->writeElement('value', $this->_value, false);
        }

        $xml->endElement(); //close tag for $this->_operation
    }
}