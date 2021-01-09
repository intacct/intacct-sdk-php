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

namespace Intacct\Xml;

use Intacct\ClientConfig;
use Intacct\Functions\FunctionInterface;
use Intacct\RequestConfig;
use Intacct\Xml\Request\ControlBlock;
use Intacct\Xml\Request\OperationBlock;

class RequestBlock
{

    /** @var string */
    protected $encoding;

    /**
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }

    /**
     * @param string $encoding
     */
    public function setEncoding(string $encoding)
    {
        $this->encoding = $encoding;
    }

    /** @var ControlBlock */
    protected $controlBlock;

    /**
     * @return ControlBlock
     */
    public function getControlBlock(): ControlBlock
    {
        return $this->controlBlock;
    }

    /**
     * @param ControlBlock $controlBlock
     */
    public function setControlBlock(ControlBlock $controlBlock)
    {
        $this->controlBlock = $controlBlock;
    }

    /** @var OperationBlock */
    protected $operationBlock;

    /**
     * @return OperationBlock
     */
    public function getOperationBlock(): OperationBlock
    {
        return $this->operationBlock;
    }

    /**
     * @param OperationBlock $operationBlock
     */
    public function setOperationBlock(OperationBlock $operationBlock)
    {
        $this->operationBlock = $operationBlock;
    }

    /**
     * RequestBlock constructor.
     *
     * @param ClientConfig $clientConfig
     * @param RequestConfig $requestConfig
     * @param FunctionInterface[] $content
     */
    public function __construct(ClientConfig $clientConfig, RequestConfig $requestConfig, array $content)
    {
        $this->setEncoding($requestConfig->getEncoding());
        $this->setControlBlock(new ControlBlock($clientConfig, $requestConfig));
        $this->operationBlock = new OperationBlock($clientConfig, $requestConfig, $content);
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
        $xml->startDocument('1.0', $this->encoding);
        $xml->startElement('request');

        $this->controlBlock->writeXml($xml); //create control block

        $this->operationBlock->writeXml($xml); //create operation block

        $xml->endElement(); //request

        return $xml;
    }
}
