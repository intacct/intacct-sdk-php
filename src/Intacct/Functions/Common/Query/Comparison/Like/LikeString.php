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

namespace Intacct\Functions\Common\Query\Comparison\Like;

use Intacct\Functions\Common\Query\Comparison\AbstractString;

class LikeString extends AbstractString
{

    /**
     * @return string
     */
    public function __toString(): string
    {
        $clause = '';
        if ($this->isNegate() === true) {
            $clause = 'NOT ';
        }
        $clause .= $this->getField() . " LIKE '" . addcslashes($this->getValue(), "'") . "'";

        return $clause;
    }
}
