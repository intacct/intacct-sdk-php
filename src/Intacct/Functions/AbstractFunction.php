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

use Intacct\Functions\Traits\ControlIdTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractFunction implements FunctionInterface
{

    use ControlIdTrait;

    /**
     * Initializes the class with the given parameters.
     *
     * @param string $controlId Control ID, default=random UUID
     */
    public function __construct($controlId = null)
    {
        $this->setControlId($controlId);
    }

    abstract public function writeXml(XMLWriter &$xml);
}
