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

namespace Intacct\Functions\Common\NewQuery\QuerySelect;

use InvalidArgumentException;

class SelectFunctionFactory
{

    /**
     * @param string $functionName
     * @param string $fieldName
     * @return AbstractSelectFunction
     * @throws InvalidArgumentException
     */
    public function create(string $functionName, string $fieldName): AbstractSelectFunction
    {
        if (!$fieldName) {
            throw new InvalidArgumentException(
                "Field name for $functionName cannot be empty or null. Provide a field name for the builder."
            );
        }

        switch ($functionName) {
            case AbstractSelectFunction::AVERAGE:
                $function = new Average($fieldName);
                break;
            case AbstractSelectFunction::COUNT:
                $function = new Count($fieldName);
                break;
            case AbstractSelectFunction::MINIMUM:
                $function = new Minimum($fieldName);
                break;
            case AbstractSelectFunction::MAXIMUM:
                $function = new Maximum($fieldName);
                break;
            case AbstractSelectFunction::SUM:
                $function = new Sum($fieldName);
                break;
            default:
                throw new InvalidArgumentException("$functionName function doesn't exist."); // TODO: Need test
                break;
        }

        return $function;
    }
}