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

namespace Intacct\Xml;

use Intacct\Xml\Request\ControlBlock;
use Intacct\Xml\Request\OperationBlock;
use Intacct\Content;
use InvalidArgumentException;

class RequestBlock
{
    
    /** @var string */
    const XML_VERSION = '1.0';

    /** @var string */
    protected $encoding;

    /** @var ControlBlock */
    protected $controlBlock;

    /** @var OperationBlock */
    protected $operationBlock;

    /**
     * Initializes the class with the given parameters.
     *
     * The constructor accepts the following options:
     *
     * - `encoding` (string, default=string "UTF-8") Encoding to use
     *
     * @param array $params RequestBlock configuration options
     * @param Content $contentBlock ContentBlock of request
     * @throws InvalidArgumentException
     */
    public function __construct(array $params, Content $contentBlock)
    {
        $defaults = [
            'encoding' => 'UTF-8',
        ];
        $config = array_merge($defaults, $params);

        if (!in_array($config['encoding'], mb_list_encodings())) {
            throw new InvalidArgumentException('Requested encoding is not supported');
        }

        $this->controlBlock = new ControlBlock($config);
        $this->operationBlock = new OperationBlock($config, $contentBlock);
    }

    /**
     * Generate the request XML writer
     *
     * @return XMLWriter
     */
    public function writeXml()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(false);
        $xml->startDocument(self::XML_VERSION, $this->encoding);
        $xml->startElement('request');

        $this->controlBlock->writeXml($xml); //create control block

        $this->operationBlock->writeXml($xml); //create operation block

        $xml->endElement(); //request

        return $xml;
    }
}
