<?php

/**
 * Copyright 2017 Sage Intacct, Inc.
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

namespace Intacct;

use ArrayIterator;
use Intacct\Functions\FunctionInterface;

class Content extends ArrayIterator
{

    /**
     * Initializes the class with the given array of FunctionInterface objects
     *
     * @param FunctionInterface[] $functions
     * @todo this should be its own collection type object, don't like magic methods
     */
    public function __construct(array $functions = [])
    {
        parent::__construct($functions);
    }
}
