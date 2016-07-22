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

use Intacct\Xml\Response\Control;
use Intacct\Xml\Response\ErrorMessage;
use Intacct\Exception;
use SimpleXMLIterator;

abstract class AbstractResponse
{
    
    /** @var SimpleXMLIterator */
    protected $xml;

    /** @var Control */
    private $control;

    /**
     * Initializes the class with the given body XML response
     *
     * @param string $body
     * @throws Exception
     */
    public function __construct($body)
    {
        libxml_use_internal_errors(true);
        $this->xml = simplexml_load_string($body, 'SimpleXMLIterator');
        if ($this->xml === false) {
            throw new Exception('XML could not be parsed properly');
        }
        libxml_clear_errors();
        libxml_use_internal_errors(false);

        if (!isset($this->xml->control)) {
            throw new Exception('Response is missing control block');
        }
        $this->setControl($this->xml->control);

        if ($this->control->getStatus() !== 'success') {
            $errors = [];
            if (isset($this->xml->errormessage)) {
                $errorMessage = new ErrorMessage($this->xml->errormessage);
                $errors = $errorMessage->getErrors();
            }
            throw new ResponseException('Response control status failure', $errors);
        }
    }

    /**
     * Set response control
     *
     * @param SimpleXMLIterator $control
     * @throws Exception
     */
    protected function setControl(SimpleXMLIterator $control)
    {
        $this->control = new Control($control);
    }

    /**
     * Get response control
     *
     * @return Control
     */
    public function getControl()
    {
        return $this->control;
    }
}
