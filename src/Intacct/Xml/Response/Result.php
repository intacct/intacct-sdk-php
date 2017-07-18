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

namespace Intacct\Xml\Response;

use Intacct\Exception\IntacctException;
use Intacct\Exception\ResultException;

class Result
{

    /** @var string */
    private $status;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    private function setStatus(string $status)
    {
        $this->status = $status;
    }

    /** @var string */
    private $function;

    /**
     * @return string
     */
    public function getFunction(): string
    {
        return $this->function;
    }

    /**
     * @param string $function
     */
    private function setFunction(string $function)
    {
        $this->function = $function;
    }

    /** @var string */
    private $controlId;

    /**
     * @return string
     */
    public function getControlId(): string
    {
        return $this->controlId;
    }

    /**
     * @param string $controlId
     */
    private function setControlId(string $controlId)
    {
        $this->controlId = $controlId;
    }

    /** @var \SimpleXMLElement */
    private $data;

    /**
     * @return \SimpleXMLElement
     */
    public function getData(): \SimpleXMLElement
    {
        return $this->data;
    }

    /**
     * @param \SimpleXMLElement $data
     */
    private function setData(\SimpleXMLElement $data)
    {
        $this->data = $data;
    }

    /** @var string */
    private $listType;

    /**
     * @return string
     */
    public function getListType(): string
    {
        return $this->listType;
    }

    /**
     * @param string $listType
     */
    private function setListType(string $listType)
    {
        $this->listType = $listType;
    }

    /** @var int */
    private $count;

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    private function setCount(int $count)
    {
        $this->count = $count;
    }

    /** @var int */
    private $totalCount;

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * @param int $totalCount
     */
    private function setTotalCount(int $totalCount)
    {
        $this->totalCount = $totalCount;
    }

    /** @var int */
    private $numRemaining;

    /**
     * @return int
     */
    public function getNumRemaining(): int
    {
        return $this->numRemaining;
    }

    /**
     * @param int $numRemaining
     */
    private function setNumRemaining(int $numRemaining)
    {
        $this->numRemaining = $numRemaining;
    }

    /** @var string */
    private $resultId;

    /**
     * @return string
     */
    public function getResultId(): string
    {
        return $this->resultId;
    }

    /**
     * @param string $resultId
     */
    private function setResultId(string $resultId)
    {
        $this->resultId = $resultId;
    }

    /** @var array */
    private $errors;

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    private function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * Result constructor.
     *
     * @param \SimpleXMLElement $result
     */
    public function __construct(\SimpleXMLElement $result)
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

        $this->setStatus(strval($result->status));
        $this->setFunction(strval($result->function));
        $this->setControlId(strval($result->controlid));

        if ($this->getStatus() !== 'success') {
            $errors = [];
            if (isset($result->errormessage)) {
                $errorMessage = new ErrorMessage($result->errormessage);
                $errors = $errorMessage->getErrors();
            }
            $this->setErrors($errors);
        }
        
        if (isset($result->data[0])) {
            $this->setData($result->data[0]);

            if (isset($result->data[0]->attributes()->listtype)) {
                $this->setListType(strval($result->data[0]->attributes()->listtype));
            }

            if (isset($result->data[0]->attributes()->count)) {
                $this->setCount(intval($result->data[0]->attributes()->count));
            }

            if (isset($result->data[0]->attributes()->totalcount)) {
                $this->setTotalCount(intval($result->data[0]->attributes()->totalcount));
            }

            if (isset($result->data[0]->attributes()->numremaining)) {
                $this->setNumRemaining(intval($result->data[0]->attributes()->numremaining));
            }

            if (isset($result->data[0]->attributes()->resultId)) {
                $this->setResultId(strval($result->data[0]->attributes()->resultId));
            }
        }
    }

    /**
     * Ensure the result status is success
     *
     * @throws ResultException
     */
    public function ensureStatusSuccess()
    {
        if ($this->getStatus() !== 'success') {
            throw new ResultException(
                'Result status: ' . $this->getStatus() . ' for Control ID: ' . $this->getControlId(),
                $this->getErrors()
            );
        }
    }

    /**
     * Ensure the result status is not failure (result status will be success or aborted)
     *
     * @throws ResultException
     */
    public function ensureStatusNotFailure()
    {
        if ($this->getStatus() === 'failure') {
            throw new ResultException(
                'Result status: ' . $this->getStatus() . ' for Control ID: ' . $this->getControlId(),
                $this->getErrors()
            );
        }
    }
}
