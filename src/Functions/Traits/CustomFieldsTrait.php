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

namespace Intacct\Functions\Traits;


use Intacct\Xml\XMLWriter;

trait CustomFieldsTrait
{
    /**
     *
     * @var string
     */
    private $customFields;

    /**
     * @return string
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * @param string $customFields
     */
    public function setCustomFields($customFields)
    {
        $this->customFields = $customFields;
    }

    public function getCustomFieldsXml(XMLWriter $xml)
    {
        if (count($this->customFields) > 0) {
            $xml->startElement('customfields');
            foreach ($this->customFields as $customFieldName => $customFieldValue) {
                $xml->startElement('customfield');
                $xml->writeElement('customfieldname', $customFieldName, true);
                $xml->writeElement('customfieldvalue', $customFieldValue, true);
                $xml->endElement(); //customfield
            }
            $xml->endElement(); //customfields
        }
    }
}