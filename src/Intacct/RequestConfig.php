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

namespace Intacct;

class RequestConfig
{

    /** @var string */
    private $controlId = '';

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
    public function setControlId(string $controlId)
    {
        $this->controlId = $controlId;
    }

    /** @var bool */
    private $transaction = false;

    /**
     * @return bool
     */
    public function isTransaction(): bool
    {
        return $this->transaction;
    }

    /**
     * @param bool $transaction
     */
    public function setTransaction(bool $transaction)
    {
        $this->transaction = $transaction;
    }

    /** @var bool */
    private $uniqueId = false;

    /**
     * @return bool
     */
    public function isUniqueId(): bool
    {
        return $this->uniqueId;
    }

    /**
     * @param bool $uniqueId
     */
    public function setUniqueId(bool $uniqueId)
    {
        $this->uniqueId = $uniqueId;
    }

    /** @var string */
    private $policyId = '';

    /**
     * @return string
     */
    public function getPolicyId(): string
    {
        return $this->policyId;
    }

    /**
     * @param string $policyId
     */
    public function setPolicyId(string $policyId)
    {
        $this->policyId = $policyId;
    }

    /** @var string */
    private $encoding = 'UTF-8';

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
        if (!in_array($encoding, mb_list_encodings())) {
            throw new \InvalidArgumentException('Encoding "' . $encoding . '" is not supported by the system');
        }
        $this->encoding = $encoding;
    }

    /** @var int */
    private $maxRetries = 5;

    /**
     * @return int
     */
    public function getMaxRetries(): int
    {
        return $this->maxRetries;
    }

    /**
     * @param int $maxRetries
     */
    public function setMaxRetries(int $maxRetries)
    {
        if ($maxRetries < 0) {
            throw new \InvalidArgumentException(
                'Max Retries must be zero or greater'
            );
        }
        $this->maxRetries = $maxRetries;
    }

    /** @var float */
    private $maxTimeout = 300;

    /**
     * The timeout of the request in seconds.
     *
     * @return float
     */
    public function getMaxTimeout(): float
    {
        return $this->maxTimeout;
    }

    /**
     * The timeout of the request in seconds. Use 0 to wait indefinitely. Default is 300.
     *
     * @param float $maxTimeout
     */
    public function setMaxTimeout(float $maxTimeout)
    {
        if ($maxTimeout < 0) {
            throw new \InvalidArgumentException(
                'Max Timeout must be zero or greater'
            );
        }
        $this->maxTimeout = $maxTimeout;
    }

    /** @var int[] */
    private $noRetryServerErrorCodes = [
        524, // CDN cut connection but system still processing request
    ];

    /**
     * @return int[]
     */
    public function getNoRetryServerErrorCodes(): array
    {
        return $this->noRetryServerErrorCodes;
    }

    /**
     * @param int[] $noRetryServerErrorCodes
     */
    public function setNoRetryServerErrorCodes(array $noRetryServerErrorCodes)
    {
        foreach ($noRetryServerErrorCodes as $errorCode) {
            if (!is_int($errorCode)) {
                throw new \InvalidArgumentException(
                    'No Retry Server Error Code is not valid int type'
                );
            }
            if ($errorCode < 500 || $errorCode > 599) {
                throw new \InvalidArgumentException(
                    'No Retry Server Error Codes must be between 500-599'
                );
            }
        }
        $this->noRetryServerErrorCodes = $noRetryServerErrorCodes;
    }

    public function __construct()
    {
        $this->setControlId(strval(time()));
    }
}
