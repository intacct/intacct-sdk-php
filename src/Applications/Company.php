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
use Intacct\Company\ClassObj;
use Intacct\Company\User;

class Company implements CompanyInterface
{
    
    /**
     *
     * @var IntacctClientInterface
     */
    private $client;
    
    /**
     *
     * @var ClassObj
     */
    private $classObj;
    
    /**
     *
     * @var User
     */
    private $user;
    
    /**
     * 
     * @param IntacctClientInterface $client
     */
    public function __construct(IntacctClientInterface &$client)
    {
        $this->client = $client;

    }
    
    /**
     * 
     * @return ClassObj
     */
    public function getClassObj()
    {
        $this->classObj = new ClassObj($this->client);
        return $this->classObj;
    }
    
    /**
     * 
     * @return User
     */
    public function getUser()
    {
        $this->user = new User($this->client);
        return $this->user;
    }
    
}