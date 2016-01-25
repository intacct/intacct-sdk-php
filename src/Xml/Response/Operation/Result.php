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

namespace Intacct\Xml\Response\Operation;

use Intacct\Xml\Response\ErrorMessage;
use ArrayIterator;
use SimpleXMLIterator;
use Exception;

class Result
{

    /**
     *
     * @var string
     */
    private $status;

    /**
     *
     * @var string
     */
    private $function;

    /**
     *
     * @var string
     */
    private $controlId;

    /**
     *
     * @var SimpleXMLIterator
     */
    private $data;

    /**
     *
     * @var array
     */
    private $errors;

    public function __construct(SimpleXMLIterator $result)
    {
        if (!isset($result->status)) {
            throw new Exception('Result block is missing status element');
        }
        if (!isset($result->function)) {
            throw new Exception('Result block is missing function element');
        }
        if (!isset($result->controlid)) {
            throw new Exception('Result block is missing controlid element');
        }

        $this->status = strval($result->status);
        $this->function = strval($result->function);
        $this->controlId = strval($result->controlid);

        $status = $this->getStatus();
        if ($status !== 'success') {
            $errors = [];
            if (isset($result->errormessage)) {
                $errorMessage = new ErrorMessage($result->errormessage);
                $errors = $errorMessage->getErrors();
            }
            $this->errors = $errors;
        }
        
        //TODO add getter/setter for elements: listtype, key, data
        
        if (isset($result->data)) {
            $this->data = $result->data;
        }
    }

    /**
     * 
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * 
     * @return string
     */
    public function getControlId()
    {
        return $this->controlId;
    }

    /**
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * 
     * @return SimpleXMLIterator
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * 
     * @param bool $nested
     * @return ArrayIterator
     */
    public function getDataArray($nested = false)
    {
        $records = new ArrayIterator();
        foreach ($this->data->children() as $record) {
            if ($nested === true) {
                //readView records inside <view> element inside <data>
                foreach ($record->children() as $nestedRecord) {
                    $records->append(json_decode(json_encode($nestedRecord), true));
                }
            } else {
                $records->append(json_decode(json_encode($record), true));
            }
        }

        return $records;
    }

}
