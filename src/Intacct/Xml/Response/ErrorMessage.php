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

namespace Intacct\Xml\Response;

class ErrorMessage
{
    
    /** @var array */
    private $errors;

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    private function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * ErrorMessage constructor.
     *
     * @param \SimpleXMLElement|null $errorMessage
     */
    public function __construct(\SimpleXMLElement $errorMessage = null)
    {
        $errors = [];
        foreach ($errorMessage->{'error'} as $error) {
            $pieces = [];
            foreach ($error->children() as $piece) {
                //strip out any tags in error messages
                $piece = htmlspecialchars_decode($this->cleanse($piece), ENT_QUOTES);

                if ($piece !== '') {
                    $pieces[] = $piece;
                }
            }

            $errors[] = implode(' ', $pieces);
        }
        $this->setErrors($errors);
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
