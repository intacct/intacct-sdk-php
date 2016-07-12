<?php

/**
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

namespace Intacct\Functions;

use Ramsey\Uuid\Uuid;
use InvalidArgumentException;

trait ControlIdTrait
{
    
    /**
     *
     * @var string
     */
    private $controlId;
    
    /**
     *
     * @return string
     */
    public function getControlId()
    {
        return $this->controlId;
    }
    
    /**
     *
     * @param string $controlId Control ID
     * @throws InvalidArgumentException
     */
    public function setControlId($controlId = null)
    {
        if (!$controlId) {
            // generate a version 4 (random) UUID
            $controlId = Uuid::uuid4()->toString();
        }
        
        $length = strlen($controlId);
        if ($length < 1 || $length > 256) {
            throw new InvalidArgumentException(
                'controlid must be between 1 and 256 characters in length'
            );
        }
        $this->controlId = $controlId;
    }
}
