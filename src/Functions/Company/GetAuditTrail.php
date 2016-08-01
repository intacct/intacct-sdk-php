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

namespace Intacct\Functions\Company;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;

class GetAuditTrail extends AbstractFunction
{

    /** @var string */
    private $objectName;

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
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'object' => null,
            'object_key' => null,
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->objectName = $config['object'];
        $this->objectKey = $config['object_key'];
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('getObjectTrail');

        $xml->writeElement('object', $this->objectName, true);
        $xml->writeElement('objectKey', $this->objectKey, true);

        $xml->endElement(); //getObjectTrail

        $xml->endElement(); //function
    }
}
