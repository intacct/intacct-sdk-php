<?php

/*
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
     * @param array $params {
     *      @var string $encoding Encoding to use, default=UTF-8
     *      @see IntacctClient::__construct for more params
     * }
     * @param Content $contentBlock
     *
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
    public function getXml()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(false);
        $xml->startDocument(self::XML_VERSION, $this->encoding);
        $xml->startElement('request');

        $this->controlBlock->getXml($xml); //create control block

        $this->operationBlock->getXml($xml); //create operation block

        $xml->endElement(); //request

        return $xml;
    }
}
