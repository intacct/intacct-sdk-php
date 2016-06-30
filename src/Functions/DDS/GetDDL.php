<?php

/**
 * Copyright 2016 Intacct Corporation.
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

namespace Intacct\Functions\DDS;

use Intacct\Functions\ControlIdTrait;
use Intacct\Functions\FunctionInterface;
use Intacct\Functions\Traits\ObjectNameTrait;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class GetDDL implements FunctionInterface
{
    use ControlIdTrait;
    use ObjectNameTrait;

    /**
     *
     * @param array $params
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'object' => null,
        ];

        $config = array_merge($defaults, $params);

        $this->setControlId($config['control_id']);
        $this->setObjectName($config['object']);
    }

    /**
     *
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('getDdsDdl');

        $xml->writeElement('object', $this->getObjectName(), true);

        $xml->endElement(); //getDdsDdl

        $xml->endElement(); //function
    }
}