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
 * Class ResponseException
 *
 * A ResponseException being thrown is generally a problem with client or request config.
 */
class ResponseException extends \RuntimeException
{

    /** @var array */
    protected $errors;

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
        $this->errors = $errors;

        if (count($errors) > 0) {
            $message = $message . ' - ' . implode(' - ', $errors);
        }

        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Get response errors as an array
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
