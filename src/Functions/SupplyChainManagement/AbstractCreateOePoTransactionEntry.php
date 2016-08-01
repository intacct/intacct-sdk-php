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

namespace Intacct\Functions\SupplyChainManagement;

abstract class AbstractCreateOePoTransactionEntry extends AbstractCreateTransactionEntry
{

    /** @var bool */
    protected $taxable;

    /** @var string */
    protected $price;

    /** @var string */
    protected $memo;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     * @todo finish me
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'taxable' => null,
            'price' => null,
            'memo' => null,
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->taxable = $config['taxable'];
        $this->price = $config['price'];
        $this->memo = $config['memo'];
    }
}
