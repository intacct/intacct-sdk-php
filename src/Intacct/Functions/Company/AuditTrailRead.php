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

namespace Intacct\Functions\Company;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;

/**
 * Read an audit trail
 */
class AuditTrailRead extends AbstractFunction
{

    /** @var string */
    private $objectName;

    /** @var string */
    private $objectKey;

    /**
     * Get object name
     *
     * @return string
     */
    public function getObjectName()
    {
        return $this->objectName;
    }

    /**
     * Set object name
     *
     * @param string $objectName
     */
    public function setObjectName($objectName)
    {
        $this->objectName = $objectName;
    }

    /**
     * Get object key
     *
     * @return string
     */
    public function getObjectKey()
    {
        return $this->objectKey;
    }

    /**
     * Set object key
     *
     * @param string $objectKey
     */
    public function setObjectKey($objectKey)
    {
        $this->objectKey = $objectKey;
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

        $xml->writeElement('object', $this->getObjectName(), true);
        $xml->writeElement('objectKey', $this->getObjectKey(), true);

        $xml->endElement(); //getObjectTrail

        $xml->endElement(); //function
    }
}
