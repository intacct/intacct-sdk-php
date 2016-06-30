<?php
/**
 * Copyright 2016 Intacct Corporation.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  use this file except in compliance with the License. You may obtain a copy
 *  of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 */

namespace Intacct\Functions\Traits;


use InvalidArgumentException;

trait ObjectNameTrait
{

    /**
     * @var string
     */
    private $objectName;

    /**
     * @param string $objectName
     * @throws InvalidArgumentException
     */
    public function setObjectName($objectName = null)
    {
        if (!$objectName) {
            throw new InvalidArgumentException('Required "object" key not supplied in params');
        }
        if (is_string($objectName) === false) {
            throw new InvalidArgumentException('object must be a string');
        }

        $this->objectName = $objectName;
    }

    /**
     * @return string
     */
    public function getObjectName()
    {
        return $this->objectName;
    }
}