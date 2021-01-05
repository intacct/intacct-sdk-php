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

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Update an existing attachments record
 */
class AttachmentsUpdate extends AbstractAttachments
{

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     * @throw InvalidArgumentException
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('update_supdoc');

        if (!$this->getAttachmentsId()) {
            throw new InvalidArgumentException('Attachments ID is required for update');
        }
        $xml->writeElement('supdocid', $this->getAttachmentsId(), true);

        $xml->writeElement('supdocname', $this->getAttachmentsName());
        $xml->writeElement('supdocfoldername', $this->getAttachmentFolderName());
        $xml->writeElement('supdocdescription', $this->getDescription());

        if (count($this->getFiles()) > 0) {
            $xml->startElement('attachments');

            foreach ($this->getFiles() as $file) {
                if ($file instanceof AttachmentInterface) {
                    $file->writeXml($xml);
                }
            }

            $xml->endElement(); //attachments
        }

        $xml->endElement(); //update_supdoc

        $xml->endElement(); //function
    }
}
