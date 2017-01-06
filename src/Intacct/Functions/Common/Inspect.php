<?php

/**
 * Copyright 2017 Intacct Corporation.
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

namespace Intacct\Functions\Common;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;

class Inspect extends AbstractFunction
{

    /** @var string */
    private $objectName;

    /** @var bool */
    private $showDetail;

    /**
     * @return string
     */
    public function getObjectName()
    {
        return $this->objectName;
    }

    /**
     * @param string $objectName
     */
    public function setObjectName($objectName)
    {
        $this->objectName = $objectName;
    }

    /**
     * @return boolean
     */
    public function isShowDetail()
    {
        return $this->showDetail;
    }

    /**
     * @param boolean $showDetail
     */
    public function setShowDetail($showDetail)
    {
        $this->showDetail = $showDetail;
    }
    
    /**
     * Get show detail
     *
     * @return string
     */
    private function writeXmlShowDetail()
    {
        return $this->isShowDetail() === true ? '1' : '0';
    }
    
    /**
     * Write the inspect block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('inspect');
        $xml->writeAttribute('detail', $this->writeXmlShowDetail());
        
        $xml->writeElement('object', $this->getObjectName(), true);
        
        $xml->endElement(); //inspect
        
        $xml->endElement(); //function
    }
}
