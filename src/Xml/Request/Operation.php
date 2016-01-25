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

namespace Intacct\Xml\Request;

use Intacct\Xml\Request\Operation\AbstractAuthentication;
use Intacct\Xml\Request\Operation\SessionAuthentication;
use Intacct\Xml\Request\Operation\LoginAuthentication;
use Intacct\Xml\Request\Operation\Content;
use XMLWriter;
use InvalidArgumentException;

class Operation
{

    /**
     *
     * @var bool
     */
    private $transaction;

    /**
     *
     * @var AbstractAuthentication 
     */
    private $authentication;

    /**
     *
     * @var Content
     */
    private $content;

    /**
     * 
     * @param array $params
     * @throws InvalidArgumentException
     */
    public function __construct(array $params, Content $content)
    {
        $defaults = [
            'transaction' => false,
            'session_id' => null,
            'company_id' => null,
            'user_id' => null,
            'user_password' => null,
        ];
        $config = array_merge($defaults, $params);

        $this->setTransaction($config['transaction']);

        if ($config['session_id']) {
            $this->authentication = new SessionAuthentication($config);
        } else if (
                $config['company_id'] && $config['user_id'] && $config['user_password']
        ) {
            $this->authentication = new LoginAuthentication($config);
        } else {
            throw new InvalidArgumentException(
                'Required "company_id", "user_id", and "user_password" keys, or "session_id" key, not supplied in params'
            );
        }
        
        $this->setContent($content);
    }

    /**
     * 
     * @param bool $transaction
     * @throws InvalidArgumentException
     */
    private function setTransaction($transaction)
    {
        if (!is_bool($transaction)) {
            throw new InvalidArgumentException('transaction not valid boolean type');
        }

        $this->transaction = $transaction;
    }

    /**
     * 
     * @return string
     */
    private function getTransaction()
    {
        $transaction = $this->transaction === true ? 'true' : 'false';

        return $transaction;
    }
    
    /**
     * 
     * @param Content $content
     */
    private function setContent(Content $content)
    {
        $this->content = $content;
    }

    /**
     * 
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('operation');
        $xml->writeAttribute('transaction', $this->getTransaction());

        $this->authentication->getXml($xml);

        $xml->startElement('content');
        foreach ($this->content as $func) {
            $func->getXml($xml);
        }
        $xml->endElement(); //content

        $xml->endElement(); //operation
    }

}
