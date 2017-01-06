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

namespace Intacct\Xml\Response\Operation;

use Intacct\Exception\IntacctException;
use Intacct\Xml\Response\ErrorMessage;
use ArrayIterator;
use SimpleXMLIterator;

class Result
{

    /** @var string */
    private $status;

    /** @var string */
    private $function;

    /** @var string */
    private $controlId;

    /** @var SimpleXMLIterator */
    private $data;

    /** @var string */
    private $listtype;

    /** @var int */
    private $count;

    /** @var int */
    private $totalcount;

    /** @var int */
    private $numremaining;

    /** @var string */
    private $resultId;

    /** @var array */
    private $errors;

    /**
     * Initializes the class
     *
     * @param SimpleXMLIterator $result
     * @throws IntacctException
     */
    public function __construct(SimpleXMLIterator $result)
    {
        if (!isset($result->status)) {
            throw new IntacctException('Result block is missing status element');
        }
        if (!isset($result->function)) {
            throw new IntacctException('Result block is missing function element');
        }
        if (!isset($result->controlid)) {
            throw new IntacctException('Result block is missing controlid element');
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
        
        if (isset($result->data)) {
            $this->data = $result->data;

            if (isset($result->data->attributes()->listtype)) {
                $this->listtype = strval($result->data->attributes()->listtype);
            }

            if (isset($result->data->attributes()->count)) {
                $this->count = intval($result->data->attributes()->count);
            }

            if (isset($result->data->attributes()->totalcount)) {
                $this->totalcount = intval($result->data->attributes()->totalcount);
            }

            if (isset($result->data->attributes()->numremaining)) {
                $this->numremaining = intval($result->data->attributes()->numremaining);
            }

            if (isset($result->data->attributes()->resultId)) {
                $this->resultId = strval($result->data->attributes()->resultId);
            }
        }
    }

    /**
     * Get result status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get function
     *
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Get control ID
     *
     * @return string
     */
    public function getControlId()
    {
        return $this->controlId;
    }

    /**
     * Get errors array
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * Get result data
     *
     * @return SimpleXMLIterator
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get result list type
     *
     * @return string
     */
    public function getListType()
    {
        return $this->listtype;
    }

    /**
     * Get result count
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Get result total count
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalcount;
    }

    /**
     * Get number remaining
     *
     * @return int
     */
    public function getNumRemaining()
    {
        return $this->numremaining;
    }

    /**
     * Get result ID for readMore function
     *
     * @return string
     */
    public function getResultId()
    {
        return $this->resultId;
    }

    /**
     * Get data array
     *
     * @param bool $nested
     *
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
