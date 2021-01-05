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

use Intacct\Exception\IntacctException;
use Intacct\Exception\ResponseException;
use Intacct\Xml\Response\Control;
use Intacct\Xml\Response\ErrorMessage;

abstract class AbstractResponse
{
    
    /** @var \SimpleXMLElement */
    private $xml;

    /**
     * @return \SimpleXMLElement
     */
    protected function getXml(): \SimpleXMLElement
    {
        return $this->xml;
    }

    /**
     * @param \SimpleXMLElement $xml
     */
    private function setXml(\SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }

    /** @var Control */
    private $control;

    /**
     * @return Control
     */
    public function getControl(): Control
    {
        return $this->control;
    }

    /**
     * @param Control $control
     */
    private function setControl(Control $control)
    {
        $this->control = $control;
    }

    /**
     * AbstractResponse constructor.
     *
     * @param string $body
     */
    public function __construct(string $body)
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($body);
        if ($xml === false) {
            throw new IntacctException('XML could not be parsed properly');
        }
        $this->setXml($xml);
        libxml_clear_errors();
        libxml_use_internal_errors(false);

        if (!isset($this->getXml()->{'control'})) {
            throw new IntacctException('Response is missing control block');
        }
        $this->setControl(new Control($this->getXml()->{'control'}[0]));

        if ($this->getControl()->getStatus() !== 'success') {
            $errors = [];
            if (isset($this->getXml()->{'errormessage'})) {
                $errorMessage = new ErrorMessage($this->getXml()->{'errormessage'});
                $errors = $errorMessage->getErrors();
            }
            throw new ResponseException('Response control status failure', $errors);
        }
    }
}
