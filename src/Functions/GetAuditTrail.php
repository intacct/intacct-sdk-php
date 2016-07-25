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

namespace Intacct\Functions;

use Intacct\Functions\Traits\ObjectNameTrait;
use Intacct\Xml\XMLWriter;
use Intacct\Xml\Request\XMLHelperTrait;
use InvalidArgumentException;

class GetAuditTrail implements FunctionInterface
{
    
    use ControlIdTrait;
    use ObjectNameTrait;
    use XMLHelperTrait;

    /** @var string */
    private $objectKey;
    
    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $control_id Control ID, default=Random UUID
     *      @var string $object Object name to get
     *      @var string $object_key Object key to get
     * }
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'object' => null,
            'object_key' => null,
        ];

        $config = array_merge($defaults, $params);

        $this->setControlId($config['control_id']);
        $this->setObjectName($config['object']);
        $this->setObjectKey($config['object_key']);
    }

    /**
     * Set object key
     *
     * @param string $objectKey
     * @throws InvalidArgumentException
     */
    private function setObjectKey($objectKey = null)
    {
        if (!$objectKey) {
            throw new InvalidArgumentException('Required "object_key" not supplied in params');
        }
        if (is_string($objectKey) === false) {
            throw new InvalidArgumentException('object_key must be a string');
        }

        $this->objectKey = $objectKey;
    }

    /**
     * Write the getObjectTrail block XML
     *
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('getObjectTrail');

        $xml->writeElement('object', $this->getObjectName(), true);

        $xml->writeElement('objectKey', $this->objectKey, true);

        $xml->endElement(); //getObjectTrail

        $xml->endElement(); //function
    }
}
