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

namespace Intacct\Functions\Common\Query;

class QueryString implements QueryInterface
{

    /**
     * @var string
     */
    protected $query;

    /**
     * QueryString constructor.
     *
     * @param string $query SQL-like query
     */
    public function __construct($query = '')
    {
        $this->setQuery($query);
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery($query)
    {
        if (!is_string($query)) {
            throw new \InvalidArgumentException('Query variable must be a string type');
        }
        $this->query = $query;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->query;
    }
}
