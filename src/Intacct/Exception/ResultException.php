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

namespace Intacct\Exception;

/**
 * Class ResultException
 *
 * A ResultException being thrown is generally a problem with an API function being executed.
 */
class ResultException extends ResponseException
{

    /**
     * Initializes the class
     *
     * @param string $message
     * @param array $errors
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct(string $message, array $errors = [], int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $errors, $code, $previous);
    }
}
