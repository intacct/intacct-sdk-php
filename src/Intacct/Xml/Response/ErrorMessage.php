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

namespace Intacct\Xml\Response;

use SimpleXMLIterator;

class ErrorMessage
{
    
    /** @var array */
    private $errors;

    /**
     * Initializes the class
     *
     * @param SimpleXMLIterator $errorMessage
     */
    public function __construct(SimpleXMLIterator $errorMessage = null)
    {
        $errors = [];
        foreach ($errorMessage->error as $error) {
            $pieces = [];
            foreach ($error->children() as $piece) {
                //strip out any tags in error messages
                $piece = $this->cleanse($piece);
                if ($piece !== '') {
                    $pieces[] = $piece;
                }
            }

            $errors[] = implode(': ', $pieces);
        }
        $this->errors = $errors;
    }
    
    /**
     * Get errors array
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Cleanse the errors by sanitizing the string
     *
     * @param string $value
     * @return string
     */
    private function cleanse($value)
    {
        return filter_var(strval($value), FILTER_SANITIZE_STRING);
    }
}
