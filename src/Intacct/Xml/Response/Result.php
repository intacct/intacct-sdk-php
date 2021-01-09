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

    /** @var \SimpleXMLElement[] */
    private $data = [];

    /**
     * @return \SimpleXMLElement[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param \SimpleXMLElement[] $data
     */
    private function setData(array $data)
    {
        $this->data = $data;
    }

    /** @var string */
    private $listType = '';

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
    private $count = 0;

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
    private $totalCount = 0;

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
    private $numRemaining = 0;

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
    private $resultId = '';

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

    /** @var string */
    private $key = '';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key)
    {
        $this->key = $key;
    }

    /** @var int */
    private $start = 0;

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @param int $start
     */
    public function setStart(int $start)
    {
        $this->start = $start;
    }

    /** @var int */
    private $end = 0;

    /**
     * @return int
     */
    public function getEnd(): int
    {
        return $this->end;
    }

    /**
     * @param int $end
     */
    public function setEnd(int $end)
    {
        $this->end = $end;
    }

    /** @var array */
    private $errors = [];

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
        if (!isset($result->{'status'})) {
            throw new IntacctException('Result block is missing status element');
        }
        if (!isset($result->{'function'})) {
            throw new IntacctException('Result block is missing function element');
        }
        if (!isset($result->{'controlid'})) {
            throw new IntacctException('Result block is missing controlid element');
        }

        $this->setStatus(strval($result->{'status'}));
        $this->setFunction(strval($result->{'function'}));
        $this->setControlId(strval($result->{'controlid'}));

        if ($this->getStatus() !== 'success') {
            $errors = [];
            if (isset($result->errormessage)) {
                $errorMessage = new ErrorMessage($result->errormessage);
                $errors = $errorMessage->getErrors();
            }
            $this->setErrors($errors);
        } else {
            if (isset($result->{'key'})) {
                $this->setKey(strval($result->{'key'} ?? ''));
            } elseif (isset($result->{'listtype'})) {
                $this->setListType(strval($result->{'listtype'} ?? ''));
                $this->setTotalCount(intval($result->{'listtype'}->attributes()->{'total'} ?? 0));
                $this->setStart(intval($result->{'listtype'}->attributes()->{'start'} ?? 0));
                $this->setEnd(intval($result->{'listtype'}->attributes()->{'end'} ?? 0));
            } elseif (isset($result->{'data'}) && isset($result->{'data'}->attributes()->{'listtype'})) {
                $this->setListType(strval($result->{'data'}->attributes()->{'listtype'} ?? ''));
                $this->setTotalCount(intval($result->{'data'}->attributes()->{'totalcount'} ?? 0));
                $this->setCount(intval($result->{'data'}->attributes()->{'count'} ?? 0));
                $this->setNumRemaining(intval($result->{'data'}->attributes()->{'numremaining'} ?? 0));
                $this->setResultId(strval($result->{'data'}->attributes()->{'resultId'} ?? ''));
            }

            if (isset($result->{'data'})) {
                $data = [];
                if ($this->getFunction() === 'readView') {
                    foreach ($result->{'data'}->{'view'}->children() as $child) {
                        $data[] = $child;
                    }
                } else {
                    foreach ($result->{'data'}->children() as $child) {
                        $data[] = $child;
                    }
                }
                $this->setData($data);
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
