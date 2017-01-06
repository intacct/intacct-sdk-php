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

namespace Intacct\Xml\Request\Operation;

use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class SessionAuthentication extends AbstractAuthentication
{

    /** @var string */
    private $sessionId;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $session_id Intacct session ID
     * }
     */
    public function __construct(array $params)
    {
        $defaults = [
            'session_id' => null,
        ];
        $config = array_merge($defaults, $params);
        
        if (!$config['session_id']) {
            throw new InvalidArgumentException(
                'Required "session_id" key not supplied in params'
            );
        }

        $this->sessionId = $config['session_id'];
    }
    
    /**
     * Write the authentication block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(&$xml)
    {
        $xml->startElement('authentication');
        $xml->writeElement('sessionid', $this->sessionId, true);
        $xml->endElement(); //authentication
    }
}
