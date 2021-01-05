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

namespace Intacct\Functions\Common\Query\Comparison;

abstract class AbstractArrayString extends AbstractComparison
{

    /**
     * @var string[]
     */
    protected $value;

    /**
     * @return string[]
     */
    public function getValue(): array
    {
        return $this->value;
    }

    /**
     * @param string[] $value
     */
    public function setValue($value)
    {
        if (count($value) > 1000) {
            throw new \OutOfRangeException('Comparison value array item count cannot exceed 1000');
        }
        foreach ($value as $key => $item) {
            if (!is_string($item)) {
                throw new \InvalidArgumentException('Comparison value array item variable must be a string type');
            }
        }
        $this->value = $value;
    }
}
