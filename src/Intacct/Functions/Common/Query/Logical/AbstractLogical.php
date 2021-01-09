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

namespace Intacct\Functions\Common\Query\Logical;

use Intacct\Functions\Common\Query\ConditionInterface;

abstract class AbstractLogical implements LogicalInterface
{

    /**
     * @var ConditionInterface[]
     */
    protected $conditions;

    /**
     * @var bool
     */
    protected $negate = false;

    /**
     * @return ConditionInterface[]
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param ConditionInterface[] $conditions
     */
    public function setConditions(array $conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * @return bool
     */
    public function isNegate(): bool
    {
        return $this->negate;
    }

    /**
     * @param bool $negate
     */
    public function setNegate(bool $negate)
    {
        $this->negate = $negate;
    }
}
