<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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

use Intacct\Xml\XMLWriter;
use Ramsey\Uuid\Uuid;

abstract class AbstractFunction implements FunctionInterface
{

    /** @var string */
    protected $controlId = '';

    /**
     * Get control ID
     *
     * @return string
     */
    public function getControlId(): string
    {
        return $this->controlId;
    }

    /**
     * Set control ID
     *
     * @param string $controlId Control ID, default=random UUID string
     * @throws \InvalidArgumentException
     */
    public function setControlId(string $controlId = '')
    {
        if (!$controlId) {
            // generate a version 4 (random) UUID
            $controlId = Uuid::uuid4()->toString();
        }

        $length = strlen($controlId);
        if ($length < 1 || $length > 256) {
            throw new \InvalidArgumentException(
                'Function Control ID must be between 1 and 256 characters in length'
            );
        }
        $this->controlId = $controlId;
    }

    /**
     * Initializes the class with the given parameters.
     *
     * @param string $controlId Control ID, default=random UUID
     */
    public function __construct(string $controlId = '')
    {
        $this->setControlId($controlId);
    }

    abstract public function writeXml(XMLWriter &$xml);
}
