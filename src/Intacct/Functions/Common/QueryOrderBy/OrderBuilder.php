<?php

/**
 * Copyright 2020 Sage Intacct, Inc.
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

namespace Intacct\Functions\Common\QueryOrderBy;

use InvalidArgumentException;

class OrderBuilder
{

    /**
     * @var OrderInterface[]
     */
    private $_orders;

    /**
     * SelectBuilder constructor.
     */
    public function __construct()
    {
        $this->_orders = [];
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function ascending(string $value) : OrderBuilder
    {
        if ( ! $value ) {
            throw new InvalidArgumentException('Fields cannot be empty or null. Provide a field for the builder.');
        }
        $_currentOrderField = new OrderAscending($value);
        $this->_orders[] = $_currentOrderField;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function descending(string $value) : OrderBuilder
    {
        if ( ! $value ) {
            throw new InvalidArgumentException('Fields cannot be empty or null. Provide a field for the builder.');
        }
        $_currentOrderField = new OrderDescending($value);
        $this->_orders[] = $_currentOrderField;

        return $this;
    }

    /**
     * @return OrderInterface[]
     */
    public function getOrders()
    {
        return $this->_orders;
    }
}