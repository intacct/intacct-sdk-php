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
 * Create a new attachments record
 */
class AttachmentsCreate extends AbstractAttachments
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

        $xml->startElement('create_supdoc');

        // Attachments ID is not required if auto-numbering is configured in module
        $xml->writeElement('supdocid', $this->getAttachmentsId(), true);

        // System sets value to 'Unnamed' if left null
        $xml->writeElement('supdocname', $this->getAttachmentsName(), true);

        if (!$this->getAttachmentFolderName()) {
            // System does not pick up user preferences for default folder
            // Nor does it pick up user's related employee default folder
            throw new InvalidArgumentException('Attachment Folder Name is required for create');
        }
        $xml->writeElement('supdocfoldername', $this->getAttachmentFolderName(), true);

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

        $xml->endElement(); //create_supdoc

        $xml->endElement(); //function
    }
}
