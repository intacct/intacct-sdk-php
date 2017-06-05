<?php

/**
 * Copyright 2017 Intacct Corporation.
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

abstract class AbstractComparison implements ComparisonInterface
{

    /**
     * @var string
     */
    protected $field;

    /**
     * @var bool
     */
    protected $negate;

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        if (!is_string($field)) {
            throw new \InvalidArgumentException('Comparison field variable must be a string type');
        }
        $this->field = $field;
    }

    /**
     * @return bool
     */
    public function isNegate()
    {
        return $this->negate;
    }

    /**
     * @param bool $negate
     */
    public function setNegate($negate)
    {
        $this->negate = $negate;
    }
}
