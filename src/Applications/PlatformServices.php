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

namespace Intacct\Applications;

use Intacct\IntacctClientInterface;
use Intacct\PlatformServices\Application;
use Intacct\PlatformServices\ApplicationInterface;

class PlatformServices implements PlatformServicesInterface
{
    
    /**
     *
     * @var IntacctClientInterface
     */
    private $client;
    
    /**
     *
     * @var ApplicationInterface
     */
    private $application;

    /**
     * 
     * @param IntacctClientInterface $client
     */
    public function __construct(IntacctClientInterface &$client)
    {
        $this->client = $client;
        
        $this->application = new Application($this->client);
    }
    
    /**
     * 
     * @return ApplicationInterface
     */
    public function getApplication()
    {
        return $this->application;
    }
    
}