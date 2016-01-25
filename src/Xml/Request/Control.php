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

use XMLWriter;
use InvalidArgumentException;

class Control
{
    
    /**
     * @var array
     */
    const DTD_VERSIONS = ['2.1', '3.0'];
    
    /**
     *
     * @var string
     */
    private $senderId;
    
    /**
     *
     * @var string
     */
    private $password;
    
    /**
     *
     * @var string
     */
    private $controlId;
    
    /**
     *
     * @var bool
     */
    private $uniqueId;
    
    /**
     *
     * @var string
     */
    private $dtdVersion;
    
    /**
     *
     * @var string
     */
    private $policyId;
    
    /**
     *
     * @var bool
     */
    private $includeWhitespace;
    
    /**
     *
     * @var bool
     */
    private $debug;

    /**
     * 
     * @param array $params
     * @throws InvalidArgumentException
     */
    public function __construct(array $params)
    {
        $defaults = [
            'sender_id' => null,
            'sender_password' => null,
            'control_id' => 'requestControlId',
            'unique_id' => false,
            'dtd_version' => '3.0',
            'policy_id' => null,
            'include_whitespace' => false,
            'debug' => false,
        ];
        $config = array_merge($defaults, $params);
        
        if (!$config['sender_id']) {
            throw new InvalidArgumentException(
                'Required "sender_id" key not supplied in params'
            );
        }
        if (!$config['sender_password']) {
            throw new InvalidArgumentException(
                'Required "sender_password" key not supplied in params'
            );
        }
        
        $this->senderId = $config['sender_id'];
        $this->password = $config['sender_password'];
        
        $this->setControlId($config['control_id']);
        $this->setUniqueId($config['unique_id']);
        $this->setDtdVersion($config['dtd_version']);
        $this->policyId = $config['policy_id'];
        $this->setIncludeWhitespace($config['include_whitespace']);
        $this->setDebug($config['debug']);
    }
    
    /**
     * 
     * @param string $controlId
     */
    private function setControlId($controlId)
    {
        $length = strlen($controlId);
        if ($length < 1 || $length > 256) {
            throw new InvalidArgumentException(
                'control_id must be between 1 and 256 characters in length'
            );
        }
        
        $this->controlId = $controlId;
    }
    
    /**
     * 
     * @param bool $uniqueId
     * @throws InvalidArgumentException
     */
    private function setUniqueId($uniqueId)
    {
        if (!is_bool($uniqueId)) {
            throw new InvalidArgumentException('uniqueid not valid boolean type');
        }
        
        $this->uniqueId = $uniqueId;
    }
    
    /**
     * 
     * @return string
     */
    private function getUniqueId()
    {
        return $this->uniqueId === true ? 'true' : 'false';
    }


    /**
     * 
     * @param string $dtdVersion
     * @throws InvalidArgumentException
     */
    private function setDtdVersion($dtdVersion)
    {
        if (!in_array($dtdVersion, self::DTD_VERSIONS)) {
            throw new InvalidArgumentException('dtdversion is not a valid version');
        }
        
        $this->dtdVersion = $dtdVersion;
    }
    
    /**
     * 
     * @param bool $includeWhitespace
     * @throws InvalidArgumentException
     */
    private function setIncludeWhitespace($includeWhitespace)
    {
        if (!is_bool($includeWhitespace)) {
            throw new InvalidArgumentException('include_whitespace not valid boolean type');
        }
        
        $this->includeWhitespace = $includeWhitespace;
    }
    
    /**
     * 
     * @return string
     */
    private function getIncludeWhitespace()
    {
        return $this->includeWhitespace === true ? 'true' : 'false';
    }
    
    /**
     * 
     * @param bool $debug
     * @throws InvalidArgumentException
     */
    private function setDebug($debug)
    {
        if (!is_bool($debug)) {
            throw new InvalidArgumentException('debug not valid boolean type');
        }
        
        $this->debug = $debug;
    }
    
    /**
     * 
     * @return string
     */
    private function getDebug()
    {
        return $this->debug === true ? 'true' : 'false';
    }
    
    /**
     * 
     * @param XMLWriter $xml
     */
    public function getXml(&$xml)
    {
        $xml->startElement('control');
        $xml->writeElement('senderid', $this->senderId);
        $xml->writeElement('password', $this->password);
        $xml->writeElement('controlid', $this->controlId);
        $xml->writeElement('uniqueid', $this->getUniqueId());
        $xml->writeElement('dtdversion', $this->dtdVersion);
        $xml->writeElement('policyid', $this->policyId);
        $xml->writeElement('includewhitespace', $this->getIncludeWhitespace());
        if ($this->dtdVersion === '2.1') {
            $xml->writeElement('debug', $this->getDebug());
        }
        $xml->endElement(); //control
    }

}
