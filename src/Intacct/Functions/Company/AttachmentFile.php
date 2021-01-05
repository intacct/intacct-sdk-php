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

class AttachmentFile implements AttachmentInterface
{

    /** @var string */
    protected $filePath;

    /** @var string */
    protected $extension;

    /** @var string */
    protected $fileName;

    /**
     * Get file path
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set file path
     *
     * @param string $filePath
     */
    public function setFilePath($filePath)
    {
        $info = pathinfo($filePath);
        if (!$this->getFileName() && isset($info['filename'])) {
            $this->setFileName($info['filename']);
        }
        if (!$this->getExtension() && isset($info['extension'])) {
            $this->setExtension($info['extension']);
        }

        $this->filePath = $filePath;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set extension
     *
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * Get file name
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set file name
     *
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Write the attachment block XML
     *
     * @param XMLWriter $xml
     * @throw InvalidArgumentException
     */
    public function writeXml(XMLWriter &$xml)
    {
        if (!$this->getFilePath()) {
            throw new InvalidArgumentException('Attachment File Path is required for create');
        }
        if (!is_readable($this->getFilePath())) {
            throw new InvalidArgumentException('Attachment File Path is not readable');
        }

        $xml->startElement('attachment');

        // The file name without a period or extension - Ex: Invoice21244
        // Needs to be unique from other files in attachment record
        $xml->writeElement('attachmentname', $this->getFileName(), true);

        // The file extension without a period - Ex: pdf
        $xml->writeElement('attachmenttype', $this->getExtension(), true);

        $fp = fopen($this->getFilePath(), 'r');
        if ($fp === false) {
            throw new InvalidArgumentException('Attachment File Path could not be opened');
        }

        // The file data needs to be base64 encoded, which makes the payload larger
        $xml->writeElement('attachmentdata', base64_encode(stream_get_contents($fp)), true);

        fclose($fp);

        $xml->endElement(); //attachment
    }
}
