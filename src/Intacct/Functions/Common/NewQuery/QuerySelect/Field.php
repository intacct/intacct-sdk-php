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

namespace Intacct\Functions\Common\NewQuery\QuerySelect;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class Field implements SelectInterface
{

    /** @var string */
    const FIELD = 'field';

    /**
     * @var string $fieldName
     */
    private $fieldName;

    /**
     * Field constructor.
     *
     * @param string $fieldName
     * @throws InvalidArgumentException
     */
    public function __construct(string $fieldName)
    {
        if (!$fieldName) {
            throw new InvalidArgumentException(
                "Field name cannot be empty or null. Provide a field name for the builder."
            );
        }

        $this->fieldName = $fieldName;
    }

    /**
     * @param XMLWriter &$xml
     */
    public function writeXML(XMLWriter &$xml)
    {
        $xml->writeElement(self::FIELD, $this->fieldName, false);
    }
}