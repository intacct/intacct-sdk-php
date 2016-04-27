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

namespace Intacct\PlatformServices;

use Intacct\IntacctClientInterface;
use Intacct\ObjectTrait;
use Intacct\Xml\Response\Operation\Result;

class Application implements ApplicationInterface
{

    use ObjectTrait;

    /**
     *
     * @var IntacctClientInterface
     */
    private $client;

    /**
     * Account constructor
     * 
     * @param IntacctClientInterface $client
     */
    public function __construct(IntacctClientInterface &$client)
    {
        $this->client = $client;
    }

    /**
     * Install a platform application
     * 
     * @param array $params
     * @return Result
     * @todo finish doc tips
     */
    public function install(array $params)
    {
        return $this->installApp($params, $this->client);
    }
    
}