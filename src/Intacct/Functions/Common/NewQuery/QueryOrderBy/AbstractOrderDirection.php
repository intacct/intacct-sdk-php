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

namespace Intacct\Functions\Common\NewQuery\QueryOrderBy;

use Intacct\Xml\XMLWriter;

abstract class AbstractOrderDirection implements OrderInterface
{

    /** @var string */
    const ASCENDING = 'ascending';

    /** @var string */
    const DESCENDING = 'descending';

    /** @var string $field */
    private $field;

    /**
     * AbstractOrderDirection constructor.
     *
     * @param string $field
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    abstract public function getDirection(): string;

    /**
     * @param XMLWriter &$xml
     */
    public function writeXML(XMLWriter &$xml)
    {
        $xml->startElement('order');
        $xml->writeElement('field', $this->field, false);
        $xml->writeElement($this->getDirection(), null, true);
        $xml->endElement(); // order
    }
}