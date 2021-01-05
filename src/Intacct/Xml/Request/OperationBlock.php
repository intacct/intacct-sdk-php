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

namespace Intacct\Xml\Request;

use Intacct\ClientConfig;
use Intacct\Credentials\LoginCredentials;
use Intacct\Credentials\SessionCredentials;
use Intacct\Functions\FunctionInterface;
use Intacct\RequestConfig;
use Intacct\Xml\XMLWriter;

class OperationBlock
{

    /** @var bool */
    private $transaction;

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

    /** @var AuthenticationInterface */
    private $authentication;

    /**
     * @return AuthenticationInterface
     */
    public function getAuthentication(): AuthenticationInterface
    {
        return $this->authentication;
    }

    /**
     * @param AuthenticationInterface $authentication
     */
    public function setAuthentication(AuthenticationInterface $authentication)
    {
        $this->authentication = $authentication;
    }

    /** @var FunctionInterface[] */
    private $content = [];

    /**
     * @return FunctionInterface[]
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * @param FunctionInterface[] $content
     */
    public function setContent(array $content)
    {
        $this->content = $content;
    }

    /**
     * OperationBlock constructor.
     *
     * @param ClientConfig $clientConfig
     * @param RequestConfig $requestConfig
     * @param FunctionInterface[] $content
     */
    public function __construct(ClientConfig $clientConfig, RequestConfig $requestConfig, array $content)
    {
        $this->setTransaction($requestConfig->isTransaction());

        $credentials = $clientConfig->getCredentials();
        if ($credentials instanceof SessionCredentials) {
            $this->setAuthentication(new SessionAuthentication($credentials->getSessionId()));
        } elseif ($credentials instanceof LoginCredentials) {
            $this->setAuthentication(new LoginAuthentication(
                $credentials->getUserId(),
                $credentials->getCompanyId(),
                $credentials->getPassword(),
                $credentials->getEntityId()
            ));
        } elseif ($clientConfig->getSessionId()) {
            $this->setAuthentication(new SessionAuthentication($clientConfig->getSessionId()));
        } elseif ($clientConfig->getCompanyId() && $clientConfig->getUserId() && $clientConfig->getUserPassword()) {
            $this->setAuthentication(new LoginAuthentication(
                $clientConfig->getUserId(),
                $clientConfig->getCompanyId(),
                $clientConfig->getUserPassword(),
                $clientConfig->getEntityId()
            ));
        } else {
            throw new \InvalidArgumentException(
                'Authentication credentials [Company ID, User ID, and User Password] or [Session ID] ' .
                'are required and cannot be blank'
            );
        }
        
        $this->setContent($content);
    }

    /**
     * Write the operation block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('operation');
        $xml->writeAttribute('transaction', $this->isTransaction() === true ? 'true' : 'false');

        $this->authentication->writeXml($xml);

        $xml->startElement('content');
        foreach ($this->getContent() as $func) {
            $func->writeXml($xml);
        }
        $xml->endElement(); //content

        $xml->endElement(); //operation
    }
}
