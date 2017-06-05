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

namespace Intacct\Xml\Request;

use Intacct\Functions\FunctionInterface;
use Intacct\Xml\Request\Operation\AbstractAuthentication;
use Intacct\Xml\Request\Operation\SessionAuthentication;
use Intacct\Xml\Request\Operation\LoginAuthentication;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class OperationBlock
{

    /** @var bool */
    private $transaction;

    /** @var AbstractAuthentication */
    private $authentication;

    /** @var FunctionInterface[] */
    private $contentBlock;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $company_id Intacct company ID
     *      @var array $module_preferences Module preferences to use for the operation
     *      @var string $session_id Intacct session ID
     *      @var bool $transaction Force the operation to be one transaction
     *      @var string $user_id Intacct user ID
     *      @var string $user_password Intacct user password
     * }
     * @param FunctionInterface[] $contentBlock
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $params, array $contentBlock)
    {
        $defaults = [
            'transaction' => false,
            'session_id' => null,
            'company_id' => null,
            'user_id' => null,
            'user_password' => null,
            'module_preferences' => [],
        ];
        $config = array_merge($defaults, $params);

        $this->setTransaction($config['transaction']);

        if ($config['session_id']) {
            $this->authentication = new SessionAuthentication($config);
        } elseif ($config['company_id'] && $config['user_id'] && $config['user_password']) {
            $this->authentication = new LoginAuthentication($config);
        } else {
            throw new InvalidArgumentException(
                'Required "company_id", "user_id", and "user_password" keys, '
                . 'or "session_id" key, not supplied in params'
            );
        }
        
        $this->setModulePreferences($config['module_preferences']);
        
        $this->setContent($contentBlock);
    }

    /**
     * Set the operation to be one transaction or not
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
     * Get if the operation is one transaction or not
     *
     * @return string
     */
    private function getTransaction()
    {
        $transaction = $this->transaction === true ? 'true' : 'false';

        return $transaction;
    }

    /**
     * Set module preferences for the operation
     *
     * @param array $modulePreferences
     *
     * @todo finish the module preferences
     */
    private function setModulePreferences(array $modulePreferences)
    {
        if (count($modulePreferences) > 0) {
            //TODO: finish this
        }
    }
    
    /**
     * Set content block of operation
     *
     * @param FunctionInterface[] $contentBlock
     */
    private function setContent(array $contentBlock)
    {
        $this->contentBlock = $contentBlock;
    }

    /**
     * Write the operation block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('operation');
        $xml->writeAttribute('transaction', $this->getTransaction());

        $this->authentication->writeXml($xml);

        $xml->startElement('content');
        foreach ($this->contentBlock as $func) {
            $func->writeXml($xml);
        }
        $xml->endElement(); //content

        $xml->endElement(); //operation
    }
}
