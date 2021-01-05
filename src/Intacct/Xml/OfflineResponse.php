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

class OfflineResponse extends AbstractResponse
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

    /**
     * OfflineResponse constructor.
     *
     * @param string $body
     */
    public function __construct(string $body)
    {
        parent::__construct($body);
        if (!isset($this->getXml()->{'acknowledgement'})) {
            throw new IntacctException('Response is missing acknowledgement block');
        }
        if (!isset($this->getXml()->{'acknowledgement'}[0]->{'status'})) {
            throw new IntacctException('Acknowledgement block is missing status element');
        }

        $this->setStatus(strval($this->getXml()->{'acknowledgement'}[0]->{'status'}));
    }
}
