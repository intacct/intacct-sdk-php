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

namespace Intacct\Functions\Common\QueryOrderBy;

use Intacct\Xml\XMLWriter;

class OrderDescending implements OrderInterface
{

    /**
     * @param string $_field
     */
    private $_field;

    /**
     * Count constructor.
     *
     * @param string $_field
     */
    public function __construct(string $_field)
    {
        $this->_field = $_field;
    }

    /**
     * @param XMLWriter $xml
     */
    public function writeXML(XMLWriter $xml)
    {
        $xml->startElement('order');
        $xml->writeElement('field', $this->_field, false);
        $xml->writeElement('descending', null, true);
        $xml->endElement(); // order
    }
}